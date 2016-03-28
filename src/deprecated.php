<?php

/*
|--------------------------------------------------------------------------
| Legacy Form field helpers
|--------------------------------------------------------------------------
|
| These have been deprecated and will be removed in a future release.
| Use blade directives or the factory instead.
|
*/

if (!function_exists('field')) {

    function field($name = null, $label = '', $options = '')
    {
        return app('clumsy.field')->make($name, $label, $options);
    }
}

if (!function_exists('checkbox')) {

    function checkbox($name = null, $label = '', $options = '')
    {
        return app('clumsy.field')->make($name, $label, $options)->type('checkbox');
    }
}

if (!function_exists('dropdown')) {

    function dropdown($name = null, $label = '', $options = '')
    {
        return app('clumsy.field')->make($name, $label, $options)->type('select');
    }
}

if (!function_exists('textarea')) {

    function textarea($name = null, $label = '', $options = '')
    {
        return app('clumsy.field')->make($name, $label, $options)->type('textarea')->autocorrect();
    }
}

if (!function_exists('hidden')) {

    function hidden($name, $value = '', $options = '')
    {
        return Collective\Html\FormFacade::hidden($name, $value, $options);
    }
}

if (!function_exists('richText')) {

    function richText($name = null, $label = '', $options = '')
    {
        return textarea($name, $label, $options)->load('tinymce')->addClass('rich-text');
    }
}

if (!function_exists('datepicker')) {

    function datepicker($name = null, $label = '', $options = '')
    {
        return app('clumsy.field')->make($name, $label, $options)
                    ->load('datepicker')
                    ->addClass('datepicker')
                    ->readonly();
    }
}

if (!function_exists('datetimepicker')) {

    function datetimepicker($name = null, $label = '', $options = '')
    {
        return app('clumsy.field')->make($name, $label, $options)
                    ->load('timepicker')
                    ->addClass('datetimepicker')
                    ->readonly();
    }
}

if (!function_exists('timepicker')) {

    function timepicker($name = null, $label = '', $options = '')
    {
        return app('clumsy.field')->make($name, $label, $options)
                    ->load('timepicker')
                    ->addClass('timepicker')
                    ->readonly();
    }
}

if (!function_exists('colorpicker')) {

    function colorpicker($name = null, $label = '', $options = '')
    {
        return app('clumsy.field')->make($name, $label, $options)->load('colorpicker')->addClass('colorpicker');
    }
}

if (!function_exists('embedVideo')) {

    function embedVideo($name = null, $label = '', $options = '')
    {
        $before = "<div class='embed-video-wrapper'>";
        $after  = '<div class="preview-box"><div class="placeholders"><div class="idle glyphicon glyphicon-film"></div>
                    <div class="error glyphicon glyphicon-exclamation-sign"></div></div></div></div>';

        return app('clumsy.field')->make($name, $label, $options)
                    ->load('embed-video')
                    ->addClass('embed-video')
                    ->beforeGroup($before)
                    ->afterGroup($after);
    }
}
