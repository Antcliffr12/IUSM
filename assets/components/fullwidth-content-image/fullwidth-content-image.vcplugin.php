<?php

function sc_fullwidth_content_image($atts) {
    extract( shortcode_atts( array(
        'title' => '',
        'title_element' => 'h2',
        'image' => '',
    ), $atts ));


	return render_component('fullwidth-content-image', [
	    'title' => $title,
        'title_element' => $title_element,
        'image' => $image,
    ]);
}
add_shortcode('fullwidth-content-image', 'sc_fullwidth_content_image');

if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('Fullwidth Component 13'),
		'base' => 'fullwidth-content-image',
		'icon' => 'icon-wpb-single-image',
		'description' => __('Displays a titled image block spanning the full width of the container.'),
		'category' => __('IUSM Components'),
		'params' => array(
			array(
				'type' => 'attach_image',
				'value' => '',
				'heading' => 'Image',
				'param_name' => 'image',
				'admin_label' => true,
			),
			array(
				'type' => 'textfield',
				'holder' => 'h2',
				'heading' => __('Title'),
				'param_name' => 'title',
				'value' => '',
				'description' => __('Enter a title here'),
			),
			array(
				'type' => 'dropdown',
				'heading' => __('Widget title element', 'js_composer'),
				'param_name' => 'title_element',
				'description' => __('Heading element for widget title.', 'js_composer'),
				'value' => array(
					__('Select Element') => '',
					__('H1', '') => 'h1',
					__('H2', '') => 'h2',
					__('H3', '') => 'h3',
				),
			),
		)
	));
}
