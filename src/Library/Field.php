<?php

namespace Clumsy\Utils\Library;

use InvalidArgumentException;
use Collective\Html\FormFacade as Form;
use Illuminate\Contracts\Support\Arrayable;

class Field
{
    protected $name;
    protected $label;
    protected $type;
    protected $feedback;

    protected $attributes = [
        'label'      => [],
        'field'      => [],
        'inputGroup' => [],
    ];

    protected $beforeGroup = null;
    protected $afterGroup = null;

    protected $defaultGroupClass = 'form-group :type';
    protected $defaultClass = ':form-control';

    protected $noLabel = false;
    protected $hideLabel = false;

    public function __construct($name = null, $label = '', array $options = []) {

        $this->name = $name;
        $this->label = $label ?: $this->labelFromName();

        if (is_null($this->name)) {
            $this->noLabel();
        }

        $this->feedback = true;
        $this->type = 'text';

        foreach ($options as $option => $value) {
            if (is_numeric($option)) {
                $this->{$value}();
                continue;
            }

            $this->{$option}($value);
        }
    }

    /**
     * Transform key from array to dot syntax.
     *
     * @param  string $key
     *
     * @return mixed
     */
    protected function transformKey($key)
    {
        return str_replace(['.', '[]', '[', ']'], ['_', '', '.', ''], $key);
    }

    protected function nameForValidation()
    {
        return $this->transformKey($this->name);
    }

    protected function labelFromName()
    {
        return title_case(str_replace('_', ' ', $this->name));
    }

    protected function getAttribute($key, $default = null)
    {
        return array_get($this->attributes, $key, $default);
    }

    protected function setAttribute($key, $value)
    {
        array_set($this->attributes, $key, $value);

        return $this;
    }

    protected function setBooleanAttribute($key, $value)
    {
        if ($value) {
            array_set($this->attributes, $key, 'true');

            return $this;
        }

        array_forget($this->attributes, $key);

        return $this;
    }

    protected function updateGroupAttributes($key, $value, $overwrite = false)
    {
        $value = $overwrite ? $value : array_merge(array_get($this->attributes, $key, []), $value);
        return array_set($this->attributes, $key, $value);
    }

    protected function classAttribute($class = null)
    {
        if (!is_array($class)) {
            $class = array_filter(explode(' ', $class));
        }

        return $class;
    }

    protected function getDefaultGroupClass()
    {
        $class = str_replace(':type', $this->type, $this->defaultGroupClass);

        return $this->classAttribute($class);
    }

    protected function getDefaultClass()
    {
        $replace = in_array($this->type, ['checkbox', 'radio']) ? '' : 'form-control';
        $class = str_replace(':form-control', $replace, $this->defaultClass);

        return $this->classAttribute($class);
    }

    protected function showFeedback()
    {
        return $this->feedback;
    }

    protected function silentFeedback()
    {
        return $this->feedback === 'silent';
    }

    protected function hasErrors()
    {
        return session()->has('errors') && session('errors')->has($this->nameForValidation());
    }

    protected function errorMessage()
    {
        return session('errors')->first($this->nameForValidation());
    }

    public function view($view)
    {
        $this->setAttribute('view', $view);

        return $this;
    }

    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function attribute($key, $value)
    {
        $this->setAttribute($key, $value);

        return $this;
    }

    public function form($form = null)
    {
        $this->setAttribute('field.form', $form);

        return $this;
    }

    public function load()
    {
        foreach (func_get_args() as $script) {
            app('clumsy.assets')->load($script);
        }

        return $this;
    }

    public function type($type)
    {
        $this->type = $type;

        return $this;
    }

    public function input($name = null, $attributes = [], $overwrite = false)
    {
        $this->name = $name;
        $this->updateGroupAttributes('field', $attributes, $overwrite);

        return $this;
    }

    public function label($label = null, $attributes = [], $overwrite = false)
    {
        $this->label = $label;
        $this->updateGroupAttributes('label', $attributes, $overwrite);

        return $this;
    }

    public function noLabel()
    {
        $this->setAttribute('label.class', 'sr-only');
        $this->noLabel = true;
        $this->hideLabel = true;

        return $this;
    }

    public function hideLabel()
    {
        $this->setAttribute('label.class', 'sr-only');
        $this->hideLabel = true;

        return $this;
    }

    public function placeholder($placeholder = null)
    {
        if ($placeholder === null) {
            $placeholder = $this->label;
        }

        $this->setAttribute('field.placeholder', $placeholder);
        $this->data('placeholder', $placeholder);

        return $this;
    }

    public function onlyPlaceholder()
    {
        $this->hideLabel()->placeholder();

        return $this;
    }

    public function noFeedback()
    {
        $this->feedback = false;

        return $this;
    }

    public function silent()
    {
        $this->feedback = 'silent';

        return $this;
    }

    public function help($text = null)
    {
        $this->after(view('clumsy/utils::help', compact('text')));

        return $this;
    }

    public function data($key, $value)
    {
        $this->setAttribute("field.data-{$key}", $value);

        return $this;
    }

    public function dynamicData($method, $value)
    {
        $key = str_replace(['data_', '_'], ['', '-'], snake_case($method));

        $this->data($key, $value);

        return $this;
    }

    public function beforeGroup($content = null)
    {
        $this->beforeGroup = $content;

        return $this;
    }

    public function beforeLabel($content = null)
    {
        $this->setAttribute('beforeLabel', $content);

        return $this;
    }

    public function before($content = null)
    {
        $this->setAttribute('before', $content);

        return $this;
    }

    public function afterGroup($content = null)
    {
        $this->afterGroup = $content;

        return $this;
    }

    public function after($content = null)
    {
        $this->setAttribute('after', $content);

        return $this;
    }

    public function prepend($content = null)
    {
        $this->setAttribute('inputGroup.before', $content);

        return $this;
    }

    public function append($content = null)
    {
        $this->setAttribute('inputGroup.after', $content);

        return $this;
    }

    public function value($value = null)
    {
        $this->setAttribute('value', $value);

        return $this;
    }

    public function selected($selected = null)
    {
        $this->value($selected);

        return $this;
    }

    public function id($id = null)
    {
        $this->setAttribute('id', $id);

        return $this;
    }

    public function idPrefix($idPrefix = null)
    {
        $this->setAttribute('idPrefix', $idPrefix);

        return $this;
    }

    public function setGroupClass($class = null)
    {
        $this->defaultGroupClass = null;
        $this->setAttribute('class', $this->classAttribute($class));

        return $this;
    }

    public function addGroupClass($class = null)
    {
        $current = (array)$this->getAttribute('class');
        $current[] = $class;
        $this->setAttribute('class', $current);

        return $this;
    }

    public function setClass($class = null)
    {
        $this->defaultClass = null;
        $this->setAttribute('field.class', $this->classAttribute($class));

        return $this;
    }

    public function addClass($class = null)
    {
        $current = (array)$this->getAttribute('field.class');
        $current[] = $class;
        $this->setAttribute('field.class', $current);

        return $this;
    }

    public function options($options = [])
    {
        if (!is_array($options)) {
            if (!is_object($options) || !($options instanceof Arrayable)) {
                throw new InvalidArgumentException('Field options must be an array or an arrayable object.');
            }

            $options = $options->toArray();
        }

        $this->setAttribute('options', $options);

        return $this;
    }

    public function tabindex($tabindex = 1)
    {
        $this->setAttribute('field.tabindex', $tabindex);

        return $this;
    }

    public function autofocus($autofocus = true)
    {
        $this->setBooleanAttribute('field.autofocus', $autofocus);

        return $this;
    }

    public function autocomplete($autocomplete)
    {
        if (is_bool($autocomplete)) {
            $autocomplete = $autocomplete ? 'on' : 'off';
        }

        $this->setAttribute('field.autocomplete', $autocomplete);

        return $this;
    }

    public function autocapitalize($autocapitalize)
    {
        if (is_bool($autocapitalize)) {
            $autocapitalize = $autocapitalize ? 'words' : 'off';
        }

        $this->setAttribute('field.autocapitalize', $autocapitalize);

        return $this;
    }

    public function autocorrect($autocorrect = true)
    {
        if (is_bool($autocorrect)) {
            $autocorrect = $autocorrect ? 'on' : 'off';
        }

        $this->setAttribute('field.autocorrect', $autocorrect);

        return $this;
    }

    public function spellcheck($spellcheck = true)
    {
        $this->setBooleanAttribute('field.spellcheck', $spellcheck);

        return $this;
    }

    public function cols($cols = 50)
    {
        $this->setAttribute('field.cols', $cols);

        return $this;
    }

    public function rows($rows = 10)
    {
        $this->setAttribute('field.rows', $rows);

        return $this;
    }

    public function checked($checked = true)
    {
        $this->setBooleanAttribute('checked', $checked);

        return $this;
    }

    public function disabled($disabled = true)
    {
        $this->setBooleanAttribute('field.disabled', $disabled);

        return $this;
    }

    public function required($required = true)
    {
        $this->setBooleanAttribute('field.required', $required);

        return $this;
    }

    public function readonly($readonly = true)
    {
        $this->setBooleanAttribute('field.readonly', $readonly);

        return $this;
    }

    public function novalidate($novalidate = true)
    {
        $this->setBooleanAttribute('field.novalidate', $novalidate);

        return $this;
    }

    public function multiple($multiple = true)
    {
        $this->setBooleanAttribute('field.multiple', $multiple);

        return $this;
    }

    public function digits()
    {
        $this->pattern('\d*');

        return $this;
    }

    public function render()
    {
        $type = $this->type;
        $attributes = $this->attributes;

        $inputGroup = array_pull($attributes, 'inputGroup');

        $labelAttributes = array_pull($attributes, 'label');

        $fieldAttributes = array_pull($attributes, 'field');
        $fieldAttributes['class'] = implode(' ', array_merge(
            $this->getDefaultClass(),
            (array)$this->getAttribute('field.class')
        ));

        $defaults = [
            'view'        => 'clumsy/utils::field',
            'value'       => null,
            'beforeLabel' => null,
            'before'      => null,
            'after'       => null,
            'id'          => null,
            'idPrefix'    => null,
            'checked'     => null,
        ];

        $attributes = array_merge($defaults, $attributes);
        extract($attributes, EXTR_SKIP);

        if (!$id) {
            $id = $idPrefix.$this->name;
        }

        if (!isset($fieldAttributes['id'])) {
            $fieldAttributes['id'] = $id;
        }

        $groupClass = array_merge($this->getDefaultGroupClass(), (array)$this->getAttribute('class'));

        $label = $this->noLabel ? '' : Form::label(array_get($labelAttributes, 'for', $id), $this->label, $labelAttributes);

        if ($this->showFeedback() && $this->name && $this->hasErrors()) {
            $groupClass[] = 'has-error';
            $groupClass[] = 'has-feedback';

            $after .= view('clumsy/utils::error-icon')->render();
            if (!$this->silentFeedback()) {
                $after .= view('clumsy/utils::error-message', ['message' => $this->errorMessage()]);
            }
        }

        $input = '';

        if (count($inputGroup)) {
            $input .= '<div class="input-group">';
            if (isset($inputGroup['before'])) {
                $groupType = strpos($inputGroup['before'], 'button') ? 'btn' : 'addon';
                $input .= '<div class="input-group-'.$groupType.'">'.$inputGroup['before'].'</div>';
            }
        }

        if (in_array($type, ['password', 'file'])) {

            $input .= Form::$type($this->name, $fieldAttributes);

        } elseif (in_array($type, ['select'])) {

            $input .= Form::$type($this->name, isset($options) ? $options : [], $value, $fieldAttributes);

        } elseif (in_array($type, ['checkbox', 'radio'])) {

            if (is_null($value) || $value === false) {
                $value = 1;
            }

            $field = Form::$type($this->name, $value, $checked, $fieldAttributes);

            if (!$this->hideLabel) {

                $labelEnd = strpos($label, '>', strpos($label, '<label'))+1;
                $input = substr_replace("{$label}{$input}", $field, $labelEnd, 0);
                $label = '';

            } else {

                $input .= $field;
            }

        } else {

            $input .= Form::$type($this->name, $value, $fieldAttributes);
        }

        if (count($inputGroup)) {
            if (isset($inputGroup['after'])) {
                $groupType = strpos($inputGroup['after'], 'button') ? 'btn' : 'addon';
                $input .= '<div class="input-group-'.$groupType.'">'.$inputGroup['after'].'</div>';
            }

            $input .= '</div>';
        }

        return view($view, [
            'beforeGroup' => $this->beforeGroup,
            'groupClass'  => implode(' ', $groupClass),
            'beforeLabel' => $beforeLabel,
            'label'       => $label,
            'before'      => $before,
            'input'       => $input,
            'after'       => $after,
            'afterGroup'  => $this->afterGroup,
        ])->render();
    }

    public function __call($method, $parameters)
    {
        if (starts_with($method, 'data')) {
            return $this->dynamicData($method, head($parameters));
        }

        return $this->setAttribute("field.{$method}", head($parameters));
    }

    public function __toString()
    {
        return $this->render();
    }
}
