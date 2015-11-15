<?php

if (!function_exists('ebr')) {

    function ebr($string)
    {
        $string = e(preg_replace('#<br\s*/?>#', "\n", $string));

        return nl2br($string);
    }
}

if (!function_exists('set_locale')) {

    function set_locale($category, $locale = false)
    {
        return Clumsy\Utils\Facades\EnvironmentLocale::set($category, $locale);
    }
}

if (!function_exists('get_possible_locales')) {

    function get_possible_locales($locale)
    {
        return Clumsy\Utils\Facades\EnvironmentLocale::getPossibleLocales($locale);
    }
}

if (!function_exists('n')) {

    function n($number)
    {
        if (class_exists('NumberFormatter')) {
            $formatter = new NumberFormatter(Clumsy\Utils\Facades\EnvironmentLocale::preferred(), NumberFormatter::DECIMAL);

            return $formatter->format($number);
        }

        return number_format($number);
    }
}

if (!function_exists('money')) {

    function money($number)
    {
        if (class_exists('NumberFormatter')) {
            $formatter = new NumberFormatter(Clumsy\Utils\Facades\EnvironmentLocale::preferred(), NumberFormatter::CURRENCY);

            return $formatter->formatCurrency((int)$number, $formatter->getTextAttribute(NumberFormatter::CURRENCY_CODE));
        }

        extract(localeconv());

        $space = $p_sep_by_space ? ' ' : '';

        $n = n($number);

        return $p_cs_precedes ? $currency_symbol.$space.$n : $n.$space.$currency_symbol;
    }
}

if (!function_exists('pc')) {

    function pc($number)
    {
        if (class_exists('NumberFormatter')) {
            $formatter = new NumberFormatter(Clumsy\Utils\Facades\EnvironmentLocale::preferred(), NumberFormatter::PERCENT);

            return $formatter->format($number);
        }

        return n((($number)*100)).'%';
    }
}

if (!function_exists('display_date')) {

    function display_date($date, $format)
    {
        return Clumsy\Utils\Facades\Date::format($date, $format);
    }
}

/*
|--------------------------------------------------------------------------
| Array helpers
|--------------------------------------------------------------------------
|
*/

if (!function_exists('array_is_associative')) {

    function array_is_associative($array)
    {
        return (bool)count(array_filter(array_keys((array)$array), 'is_string'));
    }
}

if (!function_exists('array_is_nested')) {

    function array_is_nested($array)
    {
        return (bool)is_array($array) && is_array(current($array));
    }
}

/*
|--------------------------------------------------------------------------
| Form field helpers
|--------------------------------------------------------------------------
|
*/

if (!function_exists('field')) {

    function field($name = null, $label = '', array $attributes = [])
    {
        return new Clumsy\Utils\Library\Field($name, $label, $attributes);
    }
}

if (!function_exists('checkbox')) {

    function checkbox($name = null, $label = '', array $attributes = [])
    {
        return field($name, $label, $attributes)->type('checkbox');
    }
}

if (!function_exists('dropdown')) {

    function dropdown($name = null, $label = '', array $attributes = [])
    {
        return field($name, $label, $attributes)->type('select');
    }
}

if (!function_exists('textarea')) {

    function textarea($name = null, $label = '', array $attributes = [])
    {
        return field($name, $label, $attributes)->type('textarea');
    }
}

if (!function_exists('richText')) {

    function richText($name = null, $label = '', array $attributes = [])
    {
        return textarea($name, $label, $attributes)->enqueue('tinymce')->addClass('rich-text');
    }
}

if (!function_exists('datepicker')) {

    function datepicker($name = null, $label = '', array $attributes = [])
    {
        return field($name, $label, $attributes)
                ->enqueue('datepicker')
                ->addClass('datepicker')
                ->readonly();
    }
}

if (!function_exists('datetimepicker')) {

    function datetimepicker($name = null, $label = '', array $attributes = [])
    {
        return field($name, $label, $attributes)
                ->enqueue('timepicker')
                ->addClass('datetimepicker')
                ->readonly();
    }
}

if (!function_exists('timepicker')) {

    function timepicker($name = null, $label = '', array $attributes = [])
    {
        return field($name, $label, $attributes)
                ->enqueue('timepicker')
                ->addClass('timepicker')
                ->readonly();
    }
}

if (!function_exists('colorpicker')) {

    function colorpicker($name = null, $label = '', array $attributes = [])
    {
        return field($name, $label, $attributes)->enqueue('colorpicker')->addClass('colorpicker');
    }
}

if (!function_exists('embedVideo')) {

    function embedVideo($name = null, $label = '', array $attributes = [])
    {
        $before = "<div class='embed-video-wrapper'>";
        $after  = '<div class="preview-box"><div class="placeholders"><div class="idle glyphicon glyphicon-film"></div>
                    <div class="error glyphicon glyphicon-exclamation-sign"></div></div></div></div>';

        return field($name, $label, $attributes)
                    ->enqueue('embed-video')
                    ->addClass('embed-video')
                    ->beforeGroup($before)
                    ->afterGroup($after);
    }
}