<?php
if( function_exists('vc_map')) {
    function sc_authors_all_advising($atts = array())
    {
        extract(shortcode_atts(array(
            'bg_color' => '',
            'heading' => '',
        ), $atts));

        return render_component('authors-all-advising', [
            'bg_color' => $bg_color,
            'heading' => $heading,
        ]);
    }
    add_shortcode('authors_all_advising', 'sc_authors_all_advising');


    vc_map(array(
        'name' => __('All Advising Authors'),
        'base' => 'authors_all_advising',
        'icon' => THEME_PATH . '/assets/images/icons/featured-post.png',
        'description' => __('Displays all blog authors.'),
        'category' => __('IUSM Components'),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => __('Section Heading'),
                'param_name' => 'heading',
                'value' => __('All Academic Advising Blog Authors'),
                'description' => __('Enter Heading here. Leave empty to omit.')
            ),
            array_merge($vc_shared_params_iu_bg_colors, [
                'description' => __('Select the background color for the section (extends to full width of viewport)'),
            ]),
        ),
    ));
}

