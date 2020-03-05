<?php
if( function_exists('vc_map')) {
    function sc_news_menu($atts = array())
    {

        extract(shortcode_atts(array(
            'title' => '',
            'show_search' => 'true',
        ), $atts));

        return render_component('event-menu', [
            'title' => $title,
            'show_search' => $show_search,
        ]);
    }
    add_shortcode('news_menu', 'sc_news_menu');


    vc_map(array(
        'name' => __('News Menu'),
        'base' => 'news_menu',
        //'icon' => THEME_PATH . '/assets/images/icons/featured-post.png',
        'description' => __('News Menu'),
        'category' => __('IUSM Components'),
        'params' => array(
            array(
                "type" => "textfield",
                "heading" => __("Title"),
                "param_name" => "title",
                "value" => '',
                'std' => 'Events',
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
                'description' => __('Displays event search field'),
                'std' => 'true',
            ),
        ),
    ));
}
