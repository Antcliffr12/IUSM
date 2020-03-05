<?php
if( function_exists('vc_map')) {
    function sc_blog_categories($atts = array())
    {
        extract(shortcode_atts(array(
            'bg_color' => 'bg-iu-cream',
        ), $atts));
        return render_component('blog-categories', [
            'bg_color' => $bg_color,
        ]);
    }
    add_shortcode('blog_categories', 'sc_blog_categories');

    vc_map(array(
        'name' => __('Blog Categories'),
        'base' => 'blog_categories',
        'icon' => THEME_PATH . '/assets/images/icons/featured-post.png',
        'description' => __('Displays Blog Categories'),
        'category' => __('IUSM Components'),
        'params' => array(
            array_merge($vc_shared_params_iu_bg_colors, [
                "description" => __("Choose background color.", ""),
                'std' => 'bg-iu-cream',
            ]),
		),
    ));
}