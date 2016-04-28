<?php

return [

    'passive' => true,

    'equivalences' => [
        'en' => 'en_US',
    ],

    'transformations' => [
        'Clumsy\Utils\Library\EnvironmentLocale@replaceUnderscoreTransformation',
        'Clumsy\Utils\Library\EnvironmentLocale@replaceDashTransformation',
        'Clumsy\Utils\Library\EnvironmentLocale@duplicateLocaleTransformation',
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
