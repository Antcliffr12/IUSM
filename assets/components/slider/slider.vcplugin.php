<?php
/**
 * VC Component for Slider Carousel Plugin.
 *
 */


$terms = get_list_of_term_names('kw_slick_sliders');
array_unshift($terms, 'Select');

if( function_exists('vc_map')) {
	vc_map(array(
		"name" => __("Slick Slider", ""),
		"base" => "kw-slick-slider",
		'icon' => THEME_PATH . '/assets/images/icons/media.png',
		'description' => __('Displays a slick slider', ''),
		'category' => __('IUSM Components'),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __('Title', ''),
				'param_name' => 'title',
				'value' => '',
				'description' => __('Enter a title here', '')
			),
			array(
				'type' => 'textfield',
				'heading' => __('Id', ''),
				'param_name' => 'id',
				'value' => '',
				'description' => __('Add Id for slider', ''),
			),
			array(
				'type' => 'dropdown',
				'heading' => __('Slider', ''),
				'param_name' => 'slider',
				'description' => __('Select Slick Slider to output.'),
				'value' => $terms,
			),
		)
	));
}

