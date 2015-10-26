<?php

use Illuminate\Support\Facades\Form;

/*
|--------------------------------------------------------------------------
| Array helpers
|--------------------------------------------------------------------------
|
*/

if (!function_exists('is_associative')) {

    function is_associative($array)
    {
        return array_is_associative($array);
    }
}

if (!function_exists('is_nested')) {

    function is_nested($array)
    {
        return array_is_nested($array);
    }
}

/*
|--------------------------------------------------------------------------
| Form Macros
|--------------------------------------------------------------------------
|
*/

Form::macro('field', function (
    $name = null,
    $label = '',
    $type = 'text',
    $attributes = array()
) {
    return field($name, $label, $attributes)->type($type);
});

Form::macro('fieldTextarea', function ($name, $label, $attributes = array()) {
    return textarea($name, $label, $attributes);
});

Form::macro('boolean', function ($name, $label, $attributes = array()) {
    return checkbox($name, $label, $attributes);
});

Form::macro('dropdown', function ($name, $label, $options, $selected = null, $attributes = array()) {
    return dropdown($name, $label, $attributes)->selected($selected)->options($options);
});

Form::macro('richText', function ($name, $label, $attributes = array()) {
    return richText($name, $label, $attributes);
});

Form::macro('dateTimePicker', function ($name, $label, $type = 'datepicker', $attributes = array()) {
    return $type($name, $label, $attributes);
});

Form::macro('date', function ($name, $label, $attributes = array()) {
    return datepicker($name, $label, $attributes);
});

Form::macro('datetime', function ($name, $label, $attributes = array()) {
    return datetimepicker($name, $label, $attributes);
});

Form::macro('time', function ($name, $label, $attributes = array()) {
    return timepicker($name, $label, $attributes);
});

Form::macro('colorpicker', function ($name, $label, $attributes = array()) {
    return colorpicker($name, $label, $attributes);
});

Form::macro('youtube', function ($name, $label, $attributes = array()) {
    return embedVideo($name, $label, $attributes);
});
