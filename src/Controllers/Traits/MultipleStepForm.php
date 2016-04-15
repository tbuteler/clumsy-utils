<?php

namespace Clumsy\Utils\Controllers\Traits;

use Illuminate\Support\Facades\Validator;

trait MultipleStepForm
{
    protected function sessionSlug()
    {
        return property_exists($this, 'sessionSlug') ? $this->sessionSlug : 'clumsy.utils.multiple-step-form';
    }

    protected function getSteps()
    {
        return property_exists($this, 'steps') ? (array)$this->steps : [];
    }

    protected function getRequiredSteps()
    {
        return array_keys(array_flip(array_map(function($key) {
            return $key+1;
        }, array_flip(array_values($this->getSteps())))));
    }

    protected function getSkippableSteps()
    {
        $canSkip = property_exists($this, 'canSkip') ? (array)$this->canSkip : [];
        return array_map(function ($slug) {
            return $this->getStep($slug);
        }, $canSkip);
    }

    protected function getStep($slug)
    {
        $step = array_search($slug, $this->getSteps());
        if ($step !== false) {
            return $step+1;
        }

        return false;
    }

    protected function getStepSlug($step)
    {
        $steps = $this->getSteps();
        return isset($steps[$step-1]) ? $steps[$step-1] : head($steps);
    }

    protected function isLastStep($step)
    {
        return last($this->getRequiredSteps()) == $step;
    }

    protected function getIgnoreFields()
    {
        $fields = property_exists($this, 'ignoreFields') ? (array)$this->ignoreFields : [];

        $fields[] = 'steps';

        return $fields;
    }

    protected function isProcessDirty()
    {
        return last($this->getData('steps'));
    }

    protected function lastCompletedStep()
    {
        return last($this->getData('steps'));
    }

    protected function checkStep($step)
    {
        // User is just starting out
        if ($step == 1 && !$this->isProcessDirty()) {
            return true;
        }

        // User is asking for a valid step
        $next = $this->lastCompletedStep()+1;
        if (in_array($step, $this->getRequiredSteps()) && $next >= $step) {
            return true;
        }

        // User is asking for step above what has been completed, but is allowed to skip those steps
        while ($next < $step) {
            if (!in_array($next, $this->getSkippableSteps())) {
                return false;
            }
            $this->pushStep($next);
            $next++;
        }

        return true;
    }

    protected function prepareStep($step)
    {
        $stepSlug = $this->getStepSlug($step);

        if (method_exists($this, 'beforeAllSteps')) {
            $this->beforeAllSteps($step);
        }

        $beforeMethod = 'before'.studly_case($stepSlug).'Step';
        if (method_exists($this, $beforeMethod)) {
            $this->$beforeMethod();
        }
    }

    protected function storeData(array $data = [])
    {
        session([$this->sessionSlug() => array_merge($this->getData(), $data)]);
    }

    protected function getData($key = null, $default = null)
    {
        if ($key) {
            return array_get($this->getData(), $key, $default);
        }

        return session($this->sessionSlug(), []);
    }

    protected function setData($key, $value)
    {
        $this->storeData(array_merge($this->getData(), [$key => $value]));
    }

    protected function pushStep($step)
    {
        $steps = $this->getData('steps');

        $steps[] = $step;
        $steps = array_unique($steps);
        sort($steps);

        $this->setData('steps', $steps);

        return $steps;
    }

    protected function getRules()
    {
        return property_exists($this, 'rules') ? $this->rules : [];
    }

    protected function getStepRules($step)
    {
        $stepSlug = $this->getStepSlug($step);

        return array_get($this->getRules(), $stepSlug, []);
    }

    protected function getFields($step)
    {
        return array_keys($this->getStepRules($step));
    }

    protected function postValidateStep($step, $data)
    {
        $stepSlug = $this->getStepSlug($step);

        $postMethod = 'postValidate'.studly_case($stepSlug).'Step';
        if (method_exists($this, $postMethod)) {
            $data = $this->$postMethod($data);
        }

        return $data;
    }

    public function getCurrentStep()
    {
        return request()->route()->getParameter('step');
    }

    public function show()
    {
        $step = $this->getCurrentStep();

        if (!is_array($this->getData('steps'))) {
            $this->storeData(['steps' => []]);
        }

        if (!$this->checkStep($step)) {
            $step = (int)$this->lastCompletedStep()+1;
            return redirect($this->mainPath(compact('step')));
        }

        $this->prepareStep($step);

        $stepSlug = $this->getStepSlug($step);

        $previousStep = $step-1;

        view()->share([
            'step'              => $step,
            'stepSlug'          => $stepSlug,
            'previousStep'      => $previousStep === 0 ? false : $previousStep,
            'requiredSteps'     => $this->getRequiredSteps(),
            'lastCompletedStep' => $this->lastCompletedStep(),
        ]);

        return $this->view($stepSlug, $step);
    }

    protected function view($stepSlug, $step)
    {
        return property_exists($this, 'view') ? view($this->view) : view($stepSlug);
    }

    public function processStep()
    {
        $step = $this->getCurrentStep();

        $data = request()->only($this->getFields($step));

        $validator = Validator::make($data, $this->getStepRules($step));

        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput();
        }

        $data = $this->postValidateStep($step, $data);
        $this->storeData($data);
        $this->pushStep($step);

        if ($this->isLastStep($step)) {

            $data = array_except($this->getData(), $this->getIgnoreFields());

            try {

                $processed = $this->handleLastStep($data);

            } catch (\Exception $e) {
                $error = $this->generalErrorMessage();
                if (!is_null($error)) {
                    return back()->withErrors(['general' => $this->generalErrorMessage()]);
                }
                return back();
            }

            session()->forget($this->sessionSlug());

            return redirect($this->redirectAfter($data, $processed));
        }

        $step++;

        return redirect($this->mainPath(['step' => $step]));
    }

    public function generalErrorMessage()
    {
        return property_exists($this, 'generalErrorMessage') ? $this->generalErrorMessage : null;
    }

    public function handleLastStep(array $data = [])
    {
    }

    protected function redirectAfter($data, $processed)
    {
        return property_exists($this, 'afterRoute') ? route($this->afterRoute) : $this->mainPath();
    }

    protected function mainPath(array $params = [])
    {
        return property_exists($this, 'mainRoute') ? route($this->mainRoute, $params) : '/';
    }
}
