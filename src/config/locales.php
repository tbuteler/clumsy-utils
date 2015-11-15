<?php

use Illuminate\Support\Str;

return [

    'passive' => true,

    'equivalences' => [
        'en' => 'en_US',
    ],

    'transformations' => [
        function ($locale) {
            return str_replace('_', '-', $locale);
        },
        function ($locale) {
            return str_replace('-', '_', $locale);
        },
        function ($locale) {
            if (!str_contains($locale, ['_', '-'])) {
                return Str::lower($locale).'_'.Str::upper($locale);
            }
        },
    ],

    'append' => [
        '.UTF-8',
        '.utf8',
    ],

    'fallbacks' => [
        'de-AT' => 'de',
        'de-CH' => 'de',
        'de'    => 'de-AT',
        'en-GB' => 'en',
        'en-AU' => 'en',
        'en-US' => 'en',
        'en'    => 'en-GB',
        'pt-BR' => 'pt',
        'pt'    => 'pt-BR',
    ],

];
