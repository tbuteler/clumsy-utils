<?php

$google_api = config('clumsy.utils.api-google-maps');

return [

    'jquery' => [
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js',
    ],

    'jquery-ui' => [
        'set'  => 'footer',
        'path' => '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js',
        'req'  => [
            'jquery',
            'jquery-ui.css',
        ],
    ],

    'bootstrap' => [
        'set'   => 'styles',
        'path'  => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css',
    ],

    'bootstrap.js' => [
        'set'   => 'footer',
        'path'  => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js',
        'req'   => 'jquery',
    ],

    'angular' => [
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js',
    ],

    'angular-animate' => [
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-animate.min.js',
        'req'   => 'angular',
    ],

    'angular-cookies' => [
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-cookies.min.js',
        'req'   => 'angular',
    ],

    'angular-resource' => [
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-resource.min.js',
        'req'   => 'angular',
    ],

    'angular-route' => [
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-route.min.js',
        'req'   => 'angular',
    ],

    'angular-sanitize' => [
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-sanitize.min.js',
        'req'   => 'angular',
    ],

    'angular-touch' => [
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-touch.min.js',
        'req'   => 'angular',
    ],

    'masonry' => [
        'set'   => 'footer',
        'path'  => '//cdnjs.cloudflare.com/ajax/libs/masonry/2.1.08/jquery.masonry.min.js',
        'req'   => 'jquery',
    ],

    'font-awesome' => [
        'set'   => 'styles',
        'path'  => '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
    ],

    'tinymce' => [
        'set'   => 'footer',
        'path'  => 'vendor/clumsy/utils/js/tinymce/tinymce.jquery.min.js',
        'v'     => '4.0.28',
        'req'   => 'jquery',
    ],

    'jquery-ui.css' => [
        'set'   => 'styles',
        'path'  => 'vendor/clumsy/utils/css/jquery-ui.css',
        'v'     => '1.11.4',
    ],

    'datepicker' => [
        'set'   => 'footer',
        'path'  => 'vendor/clumsy/utils/js/datepicker/{{locale}}.min.js',
        'v'     => '1.11.4',
        'req'   => [
            'jquery',
            'jquery-ui.css',
        ],
    ],

    'timepicker.css' => [
        'set'   => 'styles',
        'path'  => 'vendor/clumsy/utils/css/timepicker.css',
        'v'     => '1.5.5',
    ],

    'timepicker' => [
        'set'   => 'footer',
        'path'  => 'vendor/clumsy/utils/js/timepicker/{{locale}}.min.js',
        'v'     => '1.5.5',
        'req'   => [
            'datepicker',
            'timepicker.css',
        ],
    ],

    'chosen.css' => [
        'set'   => 'styles',
        'path'  => 'vendor/clumsy/utils/css/chosen.css',
        'v'     => '1.2.0',
    ],

    'chosen' => [
        'set'   => 'footer',
        'path'  => 'vendor/clumsy/utils/js/chosen.min.js',
        'v'     => '1.2.0',
        'req'   => [
            'jquery',
            'chosen.css',
        ],
    ],

    'colorpicker.css' => [
        'set'   => 'styles',
        'path'  => 'vendor/clumsy/utils/css/iris.css',
        'v'     => '1.0.7',
    ],

    'colorpicker' => [
        'set'   => 'footer',
        'path'  => 'vendor/clumsy/utils/js/iris.min.js',
        'v'     => '1.0.7',
        'req'   => [
            'jquery',
            'jquery-ui',
            'colorpicker.css',
        ],
    ],

    'google-maps' => [
        'set'   => 'footer',
        'path'  => "http://maps.google.com/maps/api/js?key={$google_api}&sensor=true&libraries=places,geometry",
    ],

    'embed-video' => [
        'set'   => 'footer',
        'path'  => 'vendor/clumsy/utils/js/embed-video.min.js',
        'v'     => '0.1.0',
        'req'   => 'jquery',
    ],

    'grouped-images-loader' => [
        'set'    => 'header',
        'path'   => 'vendor/clumsy/utils/js/grouped-images-loader.min.js',
        'req'    => 'jquery',
        'inline' => true,
    ],
];
