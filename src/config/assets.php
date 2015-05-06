<?php

return array(

    'jquery' => array(
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js',
    ),

    'jquery-ui' => array(
        'set'  => 'footer',
        'path' => '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js',
        'req'  => array('jquery', 'jquery-ui.css'),
    ),

    'bootstrap' => array(
        'set'   => 'styles',
        'path'  => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css',
    ),

    'bootstrap.js' => array(
        'set'   => 'footer',
        'path'  => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js',
        'req'   => 'jquery',
    ),

    'angular' => array(
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js',
    ),

    'angular-animate' => array(
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-animate.min.js',
        'req'   => 'angular',
    ),

    'angular-cookies' => array(
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-cookies.min.js',
        'req'   => 'angular',
    ),

    'angular-resource' => array(
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-resource.min.js',
        'req'   => 'angular',
    ),

    'angular-route' => array(
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-route.min.js',
        'req'   => 'angular',
    ),

    'angular-sanitize' => array(
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-sanitize.min.js',
        'req'   => 'angular',
    ),

    'angular-touch' => array(
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-touch.min.js',
        'req'   => 'angular',
    ),

    'masonry' => array(
        'set'   => 'footer',
        'path'  => '//cdnjs.cloudflare.com/ajax/libs/masonry/2.1.08/jquery.masonry.min.js',
        'req'   => 'jquery',
    ),

    'font-awesome' => array(
        'set'   => 'styles',
        'path'  => '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
    ),

    'tinymce' => array(
        'set'   => 'footer',
        'path'  => 'packages/clumsy/utils/js/tinymce/tinymce.jquery.min.js',
        'req'   => 'jquery',
        'v'     => '4.0.28',
    ),

    'jquery-ui.css' => array(
        'set'   => 'styles',
        'path'  => 'packages/clumsy/utils/css/jquery-ui.css',
        'v'     => '1.11.4',
    ),

    'datepicker' => array(
        'set'   => 'footer',
        'path'  => 'packages/clumsy/utils/js/datepicker/'.App::getLocale().'.min.js',
        'v'     => '1.11.4',
        'req'   => array('jquery', 'jquery-ui.css'),
    ),

    'timepicker.css' => array(
        'set'   => 'styles',
        'path'  => 'packages/clumsy/utils/css/timepicker.css',
        'v'     => '1.5.0',
    ),

    'timepicker' => array(
        'set'   => 'footer',
        'path'  => 'packages/clumsy/utils/js/timepicker/'.App::getLocale().'.min.js',
        'v'     => '1.5.0',
        'req'   => array('datepicker', 'timepicker.css'),
    ),

    'chosen.css' => array(
        'set'   => 'styles',
        'path'  => 'packages/clumsy/utils/css/chosen.css',
        'v'     => '1.2.0',
    ),

    'chosen' => array(
        'set'   => 'footer',
        'path'  => 'packages/clumsy/utils/js/chosen.min.js',
        'v'     => '1.2.0',
        'req'   => array(
            'jquery',
            'chosen.css',
        ),
    ),

    'colorpicker.css' => array(
        'set'   => 'styles',
        'path'  => 'packages/clumsy/utils/css/iris.css',
        'v'     => '1.0.7',
    ),

    'colorpicker' => array(
        'set'   => 'footer',
        'path'  => 'packages/clumsy/utils/js/iris.min.js',
        'v'     => '1.0.7',
        'req'   => array('jquery','jquery-ui','colorpicker.css'),
    ),

    'youtube' => array(
        'set'   => 'footer',
        'path'  => 'packages/clumsy/utils/js/youtube.min.js',
        'v'     => '0.1.0',
        'req'   => array('jquery'),
    ),
);
