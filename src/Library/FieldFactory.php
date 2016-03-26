<?php

namespace Clumsy\Utils\Library;

use Collective\Html\FormFacade as Form;
use Illuminate\Support\Traits\Macroable;

class FieldFactory
{
    use Macroable;

    protected function processOptions($options)
    {
        if (is_array($options)) {
            return $options;
        }

        $processed = [];

        $options = explode('|', $options);
        foreach (array_filter($options) as $key => $option) {
            if (!is_numeric($key)) {
                $processed[$key] = $option;
                continue;
            } elseif (str_contains($option, ':')) {
                list($option, $value) = explode(':', $option);
                $processed[$option] = $value;
                continue;
            }

            $processed[] = $option;
        }

        return $processed;
    }

    protected function mergeOptions()
    {
        $merged = [];

        foreach (func_get_args() as $options) {
            $merged = array_merge($merged, $this->processOptions($options));
        }

        return $merged;
    }

    protected function guessAttributes($name, $options)
    {
        if (!config('clumsy.field.guess-attributes')) {
            return $options;
        }

        $options = $this->processOptions($options);
        $type = array_get($options, 'type');

        $typeGuesses = config("clumsy.field.type:{$type}");
        $nameGuesses = config("clumsy.field.name:{$name}");

        return $this->mergeOptions($typeGuesses, $nameGuesses, $options);
    }

    public function make($name = null, $label = '', $options = '')
    {
        return new Field($name, $label, $this->guessAttributes($name, $options));
    }

    public function checkbox($name = null, $label = '', $options = '')
    {
        return $this->make($name, $label, $this->mergeOptions('type:checkbox', $options));
    }

    public function dropdown($name = null, $label = '', $options = '')
    {
        return $this->make($name, $label, $this->mergeOptions('type:select', $options));
    }

    public function password($name = null, $label = '', $options = '')
    {
        return $this->make($name, $label, $this->mergeOptions('type:password', $options))
                    ->load('password-toggle')
                    ->addClass('password-toggle')
                    ->append('<label class="password-toggle-label"><input type="checkbox" tabindex="-1" />'.trans('clumsy/utils::fields.show-password').'</label>');
    }

    public function textarea($name = null, $label = '', $options = '')
    {
        return $this->make($name, $label, $this->mergeOptions('type:textarea', $options));
    }

    public function richText($name = null, $label = '', $options = '')
    {
        return $this->textarea($name, $label, $options)
                    ->load('tinymce')
                    ->addClass('rich-text');
    }

    public function datepicker($name = null, $label = '', $options = '')
    {
        return $this->make($name, $label, $options)
                    ->load('datepicker')
                    ->addClass('datepicker')
                    ->readonly();
    }

    public function datetimepicker($name = null, $label = '', $options = '')
    {
        return $this->make($name, $label, $options)
                    ->load('timepicker')
                    ->addClass('datetimepicker')
                    ->readonly();
    }

    public function timepicker($name = null, $label = '', $options = '')
    {
        return $this->make($name, $label, $options)
                    ->load('timepicker')
                    ->addClass('timepicker')
                    ->readonly();
    }

    public function colorpicker($name = null, $label = '', $options = '')
    {
        return $this->make($name, $label, $options)
                    ->load('colorpicker')
                    ->addClass('colorpicker');
    }

    public function embedVideo($name = null, $label = '', $options = '')
    {
        return $this->make($name, $label, $options)
                    ->view('clumsy/utils::embed-video')
                    ->load('embed-video')
                    ->addClass('embed-video');
    }

    public function hidden($name, $value = '', $attributes = [])
    {
        return Form::hidden($name, $value, $attributes);
    }
}
