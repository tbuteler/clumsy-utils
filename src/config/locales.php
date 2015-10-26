<?php

return array(

    'passive' => true,

    'equivalences' => array(
        'en' => 'en_US',
    ),

    'transformations' => array(
        function ($locale) {
            return str_replace('_', '-', $locale);
        },
        function ($locale) {
            return str_replace('-', '_', $locale);
        },
        function ($locale) {
            if (!str_contains($locale, array('_', '-'))) {
                return \Illuminate\Support\Str::lower($locale).'_'.\Illuminate\Support\Str::upper($locale);
            }
        },
    ),

    'append' => array(
        '.UTF-8',
        '.utf8',
    ),

    'fallbacks' => array(
        'de-AT' => 'de',
        'de-CH' => 'de',
        'de'    => 'de-AT',
        'en-GB' => 'en',
        'en-AU' => 'en',
        'en-US' => 'en',
        'en'    => 'en-GB',
        'pt-BR' => 'pt',
        'pt'    => 'pt-BR',
    ),
);
