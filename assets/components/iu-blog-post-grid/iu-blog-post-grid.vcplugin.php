<?php

require_once TEMPLATEPATH . '/assets/components/iu-blog-post-grid/ajax_processing.php';

function sc_iu_blog_post_grid($atts) {

    extract( shortcode_atts( array(
        'title' => '',
    ), $atts ));

    return render_component('iu-blog-post-grid', [
        'title' => $title,
    ]);
}
add_shortcode('iu_blog_post_grid', 'sc_iu_blog_post_grid');


/**
 * Visual Composer Plugin definition
 */
if( function_exists('vc_map')) {
	vc_map(array(
		"name" => __("IU Blog Post Grid", ""),
		"base" => "iu_blog_post_grid",
		'icon' => 'icon-wpb-application-icon-large',
		'description' => __('Displays Blog Posts in grid.', ''),
		"category" => __('IUSM Components', ''),
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __("Title", ""),
				"param_name" => "title",
				"value" => "",
				"description" => __("Enter a title here", "")
			),
		)
	));
}
