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

if (!function_exists('floatAsInt')) {
    function floatAsInt($number, $scale = 100)
    {
        return (int) round(bcmul($number, $scale, 2));
    }
}

if (!function_exists('inCents')) {
    function inCents($number)
    {
        return floatAsInt($number, 100);
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

        return n(bcmul($number, 100)).'%';
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

if (!function_exists('array_is_nested')) {
    function array_is_nested($array)
    {
        return (bool)is_array($array) && is_array(current($array));
    }
}

/*
|--------------------------------------------------------------------------
| String helpers
|--------------------------------------------------------------------------
|
*/

if (!function_exists('parseLinks')) {
    function parseLinks($string)
    {
        // Links
        $string = preg_replace("/([^\w\/])(www\.[a-z0-9\-]+\.[a-z0-9\-]+)/ui", "$1http://$2", $string);
        $string = preg_replace("/([\w]+:\/\/[\w-_?&;#~%=\.\/\@]+[\w\/])/ui", "<a target=\"_blank\" href=\"$1\">$1</a>", $string);

        // e-mail
        $string = preg_replace("/([\w-_?&;#~%=\.\/]+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?))/ui", "<a href=\"mailto:$1\">$1</a>", $string);

        return $string;
    }
}

if (!function_exists('parseTweet')) {
    function parseTweet($string)
    {
        $string = parseLinks($string);

        // Twitter users
        $string = preg_replace("/@(\w+)/", "<a target=\"_blank\" href=\"https://twitter.com/$1\">@$1</a>", $string);

        // Twitter hashtags
        $string = preg_replace("/\s+#(\w+)/", "<a target=\"_blank\" href=\"https://twitter.com/hashtag/$1?src=hash\">#$1</a>", $string);

        return $string;
    }
}

/*
|--------------------------------------------------------------------------
| Grouped image
|--------------------------------------------------------------------------
|
| Ouput an image which belongs to a group of images. The advantage of this
| is having variables and events which know when all images of a certain
| group have been loaded (i.e. when it's safe to load a slider script to
| cycle through them all).
|
*/

if (!function_exists('groupedImage')) {
    function groupedImage($src, $group = null, $alt = null, array $attributes = [], $secure = null)
    {
        app('clumsy.assets')->load('grouped-images-loader');

        $attributes = array_merge(
            [
                'data-group' => $group,
                'class'      => 'grouped-image',
                'onload'     => 'groupedImageLoaded(this)',
            ],
            $attributes
        );

        return app('html')->image($src, $alt, $attributes, $secure);
    }
}

/*
|--------------------------------------------------------------------------
| Lazy loading image
|--------------------------------------------------------------------------
|
| Output an image tag which will load "lazily", complete with embedded
| 1x1 pixels transparent GIF
|
| Note: actual loading must be done by a script -- this is HTML only
|
*/

if (!function_exists('lazyLoad')) {
    function lazyLoad($src, $alt = null, array $attributes = [])
    {
        $attributes = app('html')->attributes(array_merge(
            array(
                'data-src' => $src,
                'alt'      => $alt,
                'class'    => 'lazy-load',
            ),
            $attributes
        ));

        return '<img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"'.$attributes.'>';
    }
}
