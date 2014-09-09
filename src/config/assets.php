<?php 

return array(

    'jquery' => array(
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
    ),

    'bootstrap' => array(
        'set'   => 'styles',
        'path'  => '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css',
    ),
    
    'bootstrap.js' => array(
        'set'   => 'footer',
        'path'  => '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js',
        'req'   => 'jquery',
    ),

    'angular' => array(
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.2.19/angular.min.js',
    ),
    
    'angular-animate' => array(
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.2.19/angular-animate.min.js',
        'req'   => 'angular',
    ),

    'angular-sanitize' => array(
        'set'   => 'footer',
        'path'  => '//ajax.googleapis.com/ajax/libs/angularjs/1.2.19/angular-sanitize.min.js',
        'req'   => 'angular',
    ),

    'masonry' => array(
        'set'   => 'footer',
        'path'  => 'http://cdnjs.cloudflare.com/ajax/libs/masonry/2.1.08/jquery.masonry.min.js',
        'req'   => 'jquery',
    ),

    'font-awesome' => array(
        'set'   => 'styles',
        'path'  => '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css',
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
        'v'     => '1.11.1',
    ),

    'datepicker' => array(
        'set'   => 'footer',
        'path'  => 'packages/clumsy/utils/js/datepicker/'.Config::get('app.locale').'.min.js',
        'v'     => '1.11.1',
        'req'   => array('jquery', 'jquery-ui.css'),
    ),
);
