<?php

namespace Clumsy\Utils\Library;

use Collective\Html\FormFacade as Form;

class FieldFactory
{
    public function make($name = null, $label = '', $options = '')
    {
        return new Field($name, $label, $options);
    }

    public function checkbox($name = null, $label = '', $options = '')
    {
        return $this->make($name, $label, $options)
                    ->type('checkbox');
    }

    public function dropdown($name = null, $label = '', $options = '')
    {
        return $this->make($name, $label, $options)
                    ->type('select');
    }

    public function password($name = null, $label = '', $options = '')
    {
        return $this->make($name, $label, $options)
                    ->type('password')
                    ->load('password-toggle')
                    ->addClass('password-toggle')
                    ->append('<label class="password-toggle-label"><input type="checkbox" tabindex="-1" />'.trans('clumsy/utils::fields.show-password').'</label>');
    }

    public function textarea($name = null, $label = '', $options = '')
    {
        return $this->make($name, $label, $options)
                    ->type('textarea')
                    ->autocorrect()
                    ->spellcheck();
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
