<?php

$google_api = config('clumsy.utils.api-google-maps');

return [

    /*
    |--------------------------------------------------------------------------
    | Clumsy proprietary assets
    |--------------------------------------------------------------------------
    |
    */

    'embed-video' => [
        'set'    => 'footer',
        'path'   => 'vendor/clumsy/utils/js/embed-video.min.js',
        'v'      => '0.1.0',
        'elixir' => false,
        'req'    => 'jquery',
    ],

    'grouped-images-loader' => [
        'set'    => 'header',
        'path'   => 'vendor/clumsy/utils/js/grouped-images-loader.min.js',
        'elixir' => false,
        'req'    => 'jquery',
        'inline' => true,
    ],

    'password-toggle' => [
        'set'    => 'header',
        'path'   => 'vendor/clumsy/utils/js/password-toggle.min.js',
        'elixir' => false,
        'req'    => 'jquery',
        'inline' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Google Maps
    |--------------------------------------------------------------------------
    |
    | https://developers.google.com/maps/
    |
    */

    'google-maps' => [
        'set'  => 'footer',
        'path' => "https://maps.google.com/maps/api/js?key={$google_api}&libraries=places,geometry",
    ],

    /*
    |--------------------------------------------------------------------------
    | jQuery
    |--------------------------------------------------------------------------
    |
    | https://jquery.com/
    |
    */

    'jquery' => [
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js',
    ],

    /*
    |--------------------------------------------------------------------------
    | jQuery UI
    |--------------------------------------------------------------------------
    |
    | https://jqueryui.com/
    |
    */

    'jquery-ui' => [
        'set'  => 'footer',
        'path' => '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js',
        'req'  => [
            'jquery',
            'jquery-ui.css',
        ],
    ],

    'jquery-ui.css' => [
        'set'    => 'styles',
        'path'   => 'vendor/clumsy/utils/css/jquery-ui.css',
        'v'      => '1.11.4',
        'elixir' => false,
    ],

    /**
     * Datepicker stand-alone
     */

    'datepicker' => [
        'set'   => 'footer',
        'path'  => 'vendor/clumsy/utils/js/datepicker/{{locale}}.min.js',
        'v'     => '1.11.4',
        'elixir' => false,
        'req'   => [
            'jquery',
            'jquery-ui.css',
        ],
    ],

    /**
     * Autocomplete HTML extension
     * http://github.com/scottgonzalez/jquery-ui-extensions
     */

    'autocomplete-html' => [
        'set'    => 'styles',
        'path'   => 'vendor/clumsy/utils/js/autocomplete/html-extension.min.js',
        'v'      => '1.11.4',
        'elixir' => false,
        'req'   => [
            'jquery',
            'jquery-ui'
        ],
    ],

    /**
     * Timepicker extension
     * http://trentrichardson.com/examples/timepicker/
     */

    'timepicker.css' => [
        'set'    => 'styles',
        'path'   => 'vendor/clumsy/utils/css/timepicker.css',
        'v'      => '1.6.1',
        'elixir' => false,
    ],

    'timepicker' => [
        'set'    => 'footer',
        'path'   => 'vendor/clumsy/utils/js/timepicker/{{locale}}.min.js',
        'v'      => '1.6.1',
        'elixir' => false,
        'req'    => [
            'datepicker',
            'timepicker.css',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Bootstrap
    |--------------------------------------------------------------------------
    |
    | https://getbootstrap.com/
    |
    */

    'bootstrap' => [
        'set'   => 'styles',
        'path'  => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css',
    ],

    'bootstrap.js' => [
        'set'   => 'footer',
        'path'  => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js',
        'req'   => 'jquery',
    ],

    /*
    |--------------------------------------------------------------------------
    | Vue JS
    |--------------------------------------------------------------------------
    |
    | http://vuejs.org/
    |
    */

    'vue' => [
        'set'   => 'footer',
        'path'  => [
            'default'    => 'vendor/clumsy/utils/js/vue.js',
            'production' => 'https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Angular JS
    |--------------------------------------------------------------------------
    |
    | https://www.angularjs.org/
    |
    */

    'angular' => [
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.3.17/angular.min.js',
    ],

    'angular-animate' => [
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.3.17/angular-animate.min.js',
        'req'   => 'angular',
    ],

    'angular-cookies' => [
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.3.17/angular-cookies.min.js',
        'req'   => 'angular',
    ],

    'angular-resource' => [
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.3.17/angular-resource.min.js',
        'req'   => 'angular',
    ],

    'angular-route' => [
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.3.17/angular-route.min.js',
        'req'   => 'angular',
    ],

    'angular-sanitize' => [
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.3.17/angular-sanitize.min.js',
        'req'   => 'angular',
    ],

    'angular-touch' => [
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.3.17/angular-touch.min.js',
        'req'   => 'angular',
    ],

    /*
    |--------------------------------------------------------------------------
    | Font Awesome
    |--------------------------------------------------------------------------
    |
    | https://fortawesome.github.io/Font-Awesome/
    |
    */

    'font-awesome' => [
        'set'   => 'styles',
        'path'  => '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css',
    ],

    /*
    |--------------------------------------------------------------------------
    | TinyMCE
    |--------------------------------------------------------------------------
    |
    | https://www.tinymce.com/
    |
    */

    'tinymce' => [
        'set'  => 'footer',
        'path' => '//cdn.tinymce.com/4/tinymce.min.js',
        'v'    => '4.3.8',
        'req'  => 'jquery',
    ],

    /*
    |--------------------------------------------------------------------------
    | Chosen
    |--------------------------------------------------------------------------
    |
    | https://harvesthq.github.io/chosen/
    |
    */

    'chosen.css' => [
        'set'    => 'styles',
        'path'   => 'vendor/clumsy/utils/css/chosen.css',
        'v'      => '1.4.2',
        'elixir' => false,
    ],

    'chosen' => [
        'set'    => 'footer',
        'path'   => 'vendor/clumsy/utils/js/chosen.min.js',
        'v'      => '1.4.2',
        'elixir' => false,
        'req'    => [
            'jquery',
            'chosen.css',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Iris Colorpicker
    |--------------------------------------------------------------------------
    |
    | http://automattic.github.io/Iris/
    |
    */

    'colorpicker.css' => [
        'set'    => 'styles',
        'path'   => 'vendor/clumsy/utils/css/iris.css',
        'v'      => '1.0.7',
        'elixir' => false,
    ],

    'colorpicker' => [
        'set'    => 'footer',
        'path'   => 'vendor/clumsy/utils/js/iris.min.js',
        'v'      => '1.0.7',
        'elixir' => false,
        'req'    => [
            'jquery',
            'jquery-ui',
            'colorpicker.css',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Select2
    |--------------------------------------------------------------------------
    |
    | https://select2.github.io/
    |
    */

    'select2.css' => [
        'set'    => 'styles',
        'path'   => 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css',
        'elixir' => false,
    ],

    'select2' => [
        'set'    => 'footer',
        'path'   => 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js',
        'elixir' => false,
        'req'    => [
            'jquery',
            'select2.css',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Masonry
    |--------------------------------------------------------------------------
    |
    | http://masonry.desandro.com/
    |
    */

    'masonry' => [
        'set'   => 'footer',
        'path'  => '//cdnjs.cloudflare.com/ajax/libs/masonry/2.1.08/jquery.masonry.min.js',
        'req'   => 'jquery',
    ],
];
