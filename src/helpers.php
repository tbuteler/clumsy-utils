<?php

use Clumsy\Utils\Facades\EnvironmentLocale;

if (!function_exists('ebr'))
{
    function ebr($string)
    {
        $string = e(preg_replace('#<br\s*/?>#', "\n", $string));
 
        return nl2br($string);
    }
}

if (!function_exists('set_locale'))
{
    function set_locale($category, $locale = false)
    {
        return EnvironmentLocale::set($category, $locale);
    }
}

if (!function_exists('n'))
{
    function n($number)
    {
        if (class_exists('NumberFormatter'))
        {
            $formatter = new NumberFormatter(EnvironmentLocale::preferred(), NumberFormatter::DECIMAL);

            return $formatter->format($number);
        }

        return number_format($number);
    }
}

if (!function_exists('money'))
{
    function money($number)
    {
        if (class_exists('NumberFormatter'))
        {
            $formatter = new NumberFormatter(EnvironmentLocale::preferred(), NumberFormatter::CURRENCY);

            return $formatter->formatCurrency((int)$number, $formatter->getTextAttribute(NumberFormatter::CURRENCY_CODE));
        }

        extract(localeconv());

        $space = $p_sep_by_space ? ' ' : '';
        
        $n = n($number);
        
        return $p_cs_precedes ? $currency_symbol.$space.$n : $n.$space.$currency_symbol;
    }
}

if (!function_exists('pc'))
{
    function pc($number)
    {
        if (class_exists('NumberFormatter'))
        {
            $formatter = new NumberFormatter(EnvironmentLocale::preferred(), NumberFormatter::PERCENT);

            return $formatter->format($number);
        }

        return n((($number)*100)).'%';
    }
}

if (!function_exists('display_date'))
{
    function display_date($date, $format)
    {
        return Clumsy\Utils\Facades\Date::format($date, $format);
    }
}

if (!function_exists('is_associative'))
{
    function is_associative($array)
    {
        return (bool)count(array_filter(array_keys($array), 'is_string'));
    }
}

if (!function_exists('is_nested'))
{
    function is_nested($array)
    {
        return (bool)is_array($array) && is_array(current($array));
    }
}