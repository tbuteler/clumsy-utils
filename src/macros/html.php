<?php

use Clumsy\Assets\Facade as Asset;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\HTML;

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

HTML::macro('groupedImage', function ($src, $group = null, $alt = null, $attributes = array(), $secure = null) {

    Asset::enqueue('grouped-images-loader');

    $attributes = array_merge(
        array(
            'data-group' => $group,
            'class'      => 'grouped-image',
            'onload'     => 'groupedImageLoaded(this)',
        ),
        $attributes
    );

    return HTML::image($src, $alt, $attributes, $secure);
});

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

HTML::macro('lazyLoad', function ($src, $alt = null, $attributes = array()) {

    $attributes = HTML::attributes(array_merge(
        array(
            'data-src' => $src,
            'alt'      => $alt,
            'class'    => 'lazy-load',
        ),
        $attributes
    ));

    return '<img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"'.$attributes.'>';
});
