<?php

use Clumsy\Assets\Facade as Asset;
use Illuminate\Support\Facades\Form;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| Field
|--------------------------------------------------------------------------
|
| Versatile input macro with auxiliary HTML and error feedback
|
*/
Form::macro('field', function($name, $label, $type = 'text', $attributes = array())
{
    $input_group = array_pull($attributes, 'input_group');
    
    $label_attributes = array_pull($attributes, 'label');
    
    $field_attributes = array_pull($attributes, 'field');
    $field_attributes = array_merge(
        array(
            'class' => in_array($type, array('checkbox', 'radio')) ? '' : 'form-control',
        ),
        (array)$field_attributes
    );

    $defaults = array(
        'value'        => null,
        'class'        => "form-group $type",
        'before_label' => null,
        'before'       => null,
        'after'        => null,
        'id'           => null,
        'id_prefix'    => null,
        'checked'      => false,
    );

    $attributes = array_merge($defaults, $attributes);
    extract($attributes, EXTR_SKIP);

    if (!$id)
    {
        $id = $id_prefix.$name;
    }

    if (!isset($field_attributes['id']))
    {
        $field_attributes['id'] = $id;
    }

    $class = explode(' ', $class);

    if (Session::has('errors'))
    {
        $errors = Session::get('errors');

        if ($errors->has($name))
        {
            $class[] = 'has-error';
            $class[] = 'has-feedback';

            $after .= '<span class="glyphicon glyphicon-remove form-control-feedback"></span>';
            $after .= '<p class="help-block">' . $errors->first($name) . '</p>';
        }
    }

    $class = implode(' ', $class);

    $output = "<div class=\"$class\">";

    $output .= $before_label;

    $output .= Form::label($id, $label, $label_attributes);

    $output .= $before;

    if (sizeof($input_group))
    {
        $output .= '<div class="input-group">';
        
        if (isset($input_group['before']))
        {
            $group_type = strpos($input_group['before'], 'button') ? 'btn' : 'addon';
            $output .= '<div class="input-group-'.$group_type.'">'.$input_group['before'].'</div>';
        }
    }

    if (in_array($type, array('password', 'file')))
    {
        $output .= Form::$type($name, $field_attributes);
    }
    elseif (in_array($type, array('select')))
    {
        $output .= Form::$type($name, $options, $value, $field_attributes);
    }
    elseif (in_array($type, array('checkbox', 'radio')))
    {
        if (!$value) $value = 1;
        $label_end = strpos($output, '>', strpos($output, '<label'))+1;
        $output = substr_replace($output, Form::$type($name, $value, $checked, $field_attributes), $label_end, 0);
    }
    else
    {
        $output .= Form::$type($name, $value, $field_attributes);        
    }

    if (sizeof($input_group))
    {
        if(isset($input_group['after']))
        {
            $group_type = strpos($input_group['after'], 'button') ? 'btn' : 'addon';
            $output .= '<div class="input-group-'.$group_type.'">'.$input_group['after'].'</div>';
        }
        
        $output .= '</div>';
    }

    $output .= $after;

    $output .= '</div>';
    
    return $output;
});

/*
|--------------------------------------------------------------------------
| Textarea
|--------------------------------------------------------------------------
|
| Shorthand for calling field with type textarea
|
*/
Form::macro('fieldTextarea', function($name, $label, $attributes = array())
{
    return Form::field($name, $label, 'textarea', $attributes);
});

/*
|--------------------------------------------------------------------------
| Boolean
|--------------------------------------------------------------------------
|
| Checkbox with auxiliary HTML
|
*/
Form::macro('boolean', function($name, $label, $attributes = array())
{
    return Form::field($name, $label, 'checkbox', $attributes);
});

/*
|--------------------------------------------------------------------------
| Dropdown
|--------------------------------------------------------------------------
|
| Select input with auxiliary HTML
|
*/
Form::macro('dropdown', function($name, $label, $options, $selected = null, $attributes = array())
{
    $attributes = array_merge(
        $attributes,
        array(
            'value'   => $selected,
            'options' => $options,
        )
    );

    return Form::field($name, $label, 'select', $attributes);
});

/*
|--------------------------------------------------------------------------
| Rich Text
|--------------------------------------------------------------------------
|
| Shorthand for calling Field macro while enqueuing RTE scripts
|
*/
Form::macro('richText', function($name, $label, $attributes = array())
{
    Asset::enqueue('tinymce');

    $defaults = array(
        'class' => 'form-control rich-text',
    );
    $attributes['field'] = isset($attributes['field']) ? array_merge($defaults, $attributes['field']) : $defaults;

    return Form::field($name, $label, 'textarea', $attributes);
});

/*
|--------------------------------------------------------------------------
| Date and timepicker
|--------------------------------------------------------------------------
|
| Shorthand for calling Field macro while enqueuing date and timepicker scripts
|
*/
Form::macro('dateTimePicker', function($name, $label, $type = 'datepicker', $attributes = array())
{
    Asset::enqueue($type === 'datepicker' ? 'datepicker' : 'timepicker');

    $defaults = array(
        'class'    => "form-control $type",
        'readonly' => 'readonly',
    );
    $attributes['field'] = isset($attributes['field']) ? array_merge($defaults, $attributes['field']) : $defaults;

    return Form::field($name, $label, 'text', $attributes);
});

Form::macro('date', function($name, $label, $attributes = array())
{
    return Form::dateTimePicker($name, $label, 'datepicker', $attributes);
});

Form::macro('datetime', function($name, $label, $attributes = array())
{
    return Form::dateTimePicker($name, $label, 'datetimepicker', $attributes);
});

Form::macro('time', function($name, $label, $attributes = array())
{
    return Form::dateTimePicker($name, $label, 'timepicker', $attributes);
});

/*
|--------------------------------------------------------------------------
| Colorpicker
|--------------------------------------------------------------------------
|
| Shorthand for calling Field macro while enqueuing iris colorpicker scripts
|
*/
Form::macro('colorpicker', function($name, $label, $attributes = array())
{
    Asset::enqueue('colorpicker');

    $defaults = array(
        'class'    => "form-control colorpicker",
    );
    $attributes['field'] = isset($attributes['field']) ? array_merge($defaults, $attributes['field']) : $defaults;

    return Form::field($name, $label, 'text', $attributes);
});

/*
|--------------------------------------------------------------------------
| Youtube box
|--------------------------------------------------------------------------
|   
| Shorthand for calling Field macro while enqueuing youtube scripts
|
*/
Form::macro('youtube', function($name, $label, $attributes = array())
{
    Asset::enqueue('youtube');

    $defaults = array(
        'class' => 'form-group youtube-url',
    );

    $attributes = array_merge($defaults, $attributes);

    $output = "<div class='youtube-wrapper'>";

    $output .= Form::field($name, $label,'text',$attributes);

    $output .= '<div class="preview-box"><div class="placeholders"><div class="idle glyphicon glyphicon-film"></div>
                <div class="error glyphicon glyphicon-exclamation-sign"></div></div></div></div>';

    return $output;
});