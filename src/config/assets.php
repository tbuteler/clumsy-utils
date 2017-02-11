<?php

$google_api = env('API_GOOGLE_MAPS', '');

return [

    /*
    |--------------------------------------------------------------------------
    | Clumsy proprietary assets
    |--------------------------------------------------------------------------
    |
    */

    'embed-video' => [
        'set'      => 'footer',
        'path'     => 'vendor/clumsy/utils/js/embed-video.min.js',
        'hash'     => false,
        'version'  => '0.1.0',
        'requires' => 'jquery',
    ],

    'grouped-images-loader' => [
        'set'      => 'header',
        'path'     => 'vendor/clumsy/utils/js/grouped-images-loader.min.js',
        'hash'     => false,
        'requires' => 'jquery',
        'inline'   => true,
    ],

    'password-toggle' => [
        'set'      => 'header',
        'path'     => 'vendor/clumsy/utils/js/password-toggle.min.js',
        'hash'     => false,
        'requires' => 'jquery',
        'inline'   => true,
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
        'set'     => 'footer',
        'path'    => '//ajax.googleapis.com/ajax/libs/jquery/{{version}}/jquery.min.js',
        'version' => '3.1.1',
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
        'set'      => 'footer',
        'path'     => '//ajax.googleapis.com/ajax/libs/jqueryui/{{version}}/jquery-ui.min.js',
        'version'  => '1.11.4',
        'requires' => [
            'jquery',
            'jquery-ui.css',
        ],
    ],

    'jquery-ui.css' => [
        'set'     => 'styles',
        'path'    => 'vendor/clumsy/utils/css/jquery-ui.css',
        'version' => '1.11.4',
        'hash'    => false,
    ],

    /**
     * Datepicker stand-alone
     */

    'datepicker' => [
        'set'      => 'footer',
        'path'     => 'vendor/clumsy/utils/js/datepicker/{{locale}}.min.js',
        'hash'     => false,
        'version'  => '1.11.4',
        'requires' => [
            'jquery',
            'jquery-ui.css',
        ],
    ],

    /**
     * Autocomplete HTML extension
     * http://github.com/scottgonzalez/jquery-ui-extensions
     */

    'autocomplete-html' => [
        'set'      => 'styles',
        'path'     => 'vendor/clumsy/utils/js/autocomplete/html-extension.min.js',
        'version'  => '1.11.4',
        'hash'     => false,
        'requires' => [
            'jquery',
            'jquery-ui',
        ],
    ],

    /**
     * Timepicker extension
     * http://trentrichardson.com/examples/timepicker/
     */

    'timepicker.css' => [
        'set'     => 'styles',
        'path'    => 'vendor/clumsy/utils/css/timepicker.css',
        'version' => '1.6.3',
        'hash'    => false,
    ],

    'timepicker' => [
        'set'      => 'footer',
        'path'     => 'vendor/clumsy/utils/js/timepicker/{{locale}}.min.js',
        'version'  => '1.6.3',
        'hash'     => false,
        'requires' => [
            'jquery-ui',
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
        'set'     => 'styles',
        'path'    => '//maxcdn.bootstrapcdn.com/bootstrap/{{version}}/css/bootstrap.min.css',
        'version' => '3.3.7',
    ],

    'bootstrap.js' => [
        'set'      => 'footer',
        'path'     => '//maxcdn.bootstrapcdn.com/bootstrap/{{version}}/js/bootstrap.min.js',
        'version'  => '3.3.7',
        'requires' => 'jquery',
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
            'production' => 'https://cdnjs.cloudflare.com/ajax/libs/vue/{{version}}/vue.min.js',
        ],
        'version' => '2.1.10',
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
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/{{version}}/angular.min.js',
        'version'  => '1.5.7',
    ],

    'angular-animate' => [
        'set'      => 'footer',
        'path'     => '//ajax.googleapis.com/ajax/libs/angularjs/{{version}}/angular-animate.min.js',
        'version'  => '1.5.7',
        'requires' => 'angular',
    ],

    'angular-cookies' => [
        'set'      => 'footer',
        'path'     => '//ajax.googleapis.com/ajax/libs/angularjs/{{version}}/angular-cookies.min.js',
        'version'  => '1.5.7',
        'requires' => 'angular',
    ],

    'angular-resource' => [
        'set'      => 'footer',
        'path'     => '//ajax.googleapis.com/ajax/libs/angularjs/{{version}}/angular-resource.min.js',
        'version'  => '1.5.7',
        'requires' => 'angular',
    ],

    'angular-route' => [
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/{{version}}/angular-route.min.js',
        'version'  => '1.5.7',
        'requires'   => 'angular',
    ],

    'angular-sanitize' => [
        'set'      => 'footer',
        'path'     => '//ajax.googleapis.com/ajax/libs/angularjs/{{version}}/angular-sanitize.min.js',
        'version'  => '1.5.7',
        'requires' => 'angular',
    ],

    'angular-touch' => [
        'set'      => 'footer',
        'path'     => '//ajax.googleapis.com/ajax/libs/angularjs/{{version}}/angular-touch.min.js',
        'version'  => '1.5.7',
        'requires' => 'angular',
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
        'set'     => 'styles',
        'path'    => '//maxcdn.bootstrapcdn.com/font-awesome/{{version}}/css/font-awesome.min.css',
        'version' => '4.7.0',
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
        'set'      => 'footer',
        'path'     => '//cdn.tinymce.com/4/tinymce.min.js',
        'version'  => '4.3.12',
        'requires' => 'jquery',
    ],

    /*
    |--------------------------------------------------------------------------
    | SimpleMDE Markdown Editor
    |--------------------------------------------------------------------------
    |
    | https://simplemde.com/
    |
    */

    'simplemde.css' => [
        'set'     => 'styles',
        'path'    => 'https://cdn.jsdelivr.net/simplemde/{{version}}/simplemde.min.css',
        'hash'    => false,
        'version' => '1.11.2',
    ],

    'simplemde' => [
        'set'      => 'footer',
        'path'     => 'https://cdn.jsdelivr.net/simplemde/{{version}}/simplemde.min.js',
        'hash'     => false,
        'version'  => '1.11.2',
        'requires' => [
            'simplemde.css',
        ],
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
        'set'     => 'styles',
        'path'    => 'vendor/clumsy/utils/css/chosen.css',
        'hash'    => false,
        'version' => '1.6.2',
    ],

    'chosen' => [
        'set'      => 'footer',
        'path'     => 'vendor/clumsy/utils/js/chosen.min.js',
        'hash'     => false,
        'version'  => '1.6.2',
        'requires' => [
            'jquery',
            'chosen.css',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sweet Alert
    |--------------------------------------------------------------------------
    |
    | http://t4t5.github.io/sweetalert/
    |
    */

    'sweetalert.css' => [
        'set'     => 'styles',
        'path'    => 'vendor/clumsy/utils/css/sweetalert.css',
        'hash'    => false,
        'version' => '1.1.3',
    ],

    'sweetalert' => [
        'set'      => 'footer',
        'path'     => 'vendor/clumsy/utils/js/sweetalert.min.js',
        'hash'     => false,
        'version'  => '1.1.3',
        'requires' => [
            'sweetalert.css',
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
        'set'     => 'styles',
        'path'    => 'vendor/clumsy/utils/css/iris.css',
        'hash'    => false,
        'version' => '1.0.7',
    ],

    'colorpicker' => [
        'set'      => 'footer',
        'path'     => 'vendor/clumsy/utils/js/iris.min.js',
        'hash'     => false,
        'version'  => '1.0.7',
        'requires' => [
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
        'path'   => 'https://cdnjs.cloudflare.com/ajax/libs/select2/{{version}}/css/select2.min.css',
        'version'  => '4.0.3',
    ],

    'select2' => [
        'set'      => 'footer',
        'path'     => 'https://cdnjs.cloudflare.com/ajax/libs/select2/{{version}}/js/select2.min.js',
        'version'  => '4.0.3',
        'requires' => [
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
        'set'      => 'footer',
        'path'     => '//cdnjs.cloudflare.com/ajax/libs/masonry/{{version}}/jquery.masonry.min.js',
        'version'  => '2.1.08',
        'requires' => 'jquery',
    ],
];
