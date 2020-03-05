<?php

function imageSizes()
{
    if(function_exists('add_image_size')){
        add_image_size('iu-large', '960', '480', ['center', 'top']);
        add_image_size('iu-medium', '360', '240', ['center', 'top']);
        add_image_size('iu-small', '260', '130', ['center', 'top']);
        add_image_size('iu-extra-small', '120', '180', ['center', 'top']);

        add_image_size('vertical_large', '200', '9999', false);
        add_image_size('vertical_medium', '200', '9999', false);
        add_image_size('vertical_small', '160', '9999', false);
        add_image_size('vertical_large', '300', '9999', false);
        add_image_size('vertical_xtra_large', '760', '9999', false);





    }
}

function addToMediaLibraryList(){
    $sizes = [
        'iu-large' => __('Horizontal Large', ''),
        'iu-medium' => __('Horizontal Medium', ''),
        'iu-small' => __('Horizontal Small', ''),
        'iu-extra-small' => __('Horizontal Extra Small', ''),
        'vertical_medium' => __('Vertical Medium', ''),
        'vertical_small' => __('Vertical Small', ''),
        'vertical_large' => __('Large Vertical', ''),
        'vertical_xtra_large' => __('Extra Large Vertical', '')

    ];
    return $sizes;
}


add_action( 'init', 'imageSizes');
add_filter( 'image_size_names_choose', 'addToMediaLibraryList' );
