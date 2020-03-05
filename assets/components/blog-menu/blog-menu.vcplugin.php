<?php
if( function_exists('vc_map')) {
    function sc_blog_menu($atts = array())
    {

        extract(shortcode_atts(array(
            'title' => '',
            'show_search' => 'true',
        ), $atts));

        return render_component('blog-menu', [
            'title' => $title,
            'show_search' => $show_search,
        ]);
    }
    add_shortcode('blog_menu', 'sc_blog_menu');


    vc_map(array(
        'name' => __('Blog Menu'),
        'base' => 'blog_menu',
        'icon' => THEME_PATH . '/assets/images/icons/featured-post.png',
        'description' => __('Blog Menu'),
        'category' => __('IUSM Components'),
        'params' => array(
            array(
                "type" => "textfield",
                "heading" => __("Title"),
                "param_name" => "title",
                "value" => '',
                'std' => 'Campuses',
                "description" => __("Title text to display above widget")
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Show Search'),
                'param_name' => 'show_search',
                'value' => array(
                    'false',
                    'true',
                ),
                'description' => __('Displays blog search field'),
                'std' => 'true',
            ),
        ),
    ));
}