<?php
/**
 * Shortcode processor for Quote Box
 * @param $atts Shortcode attribute array
 * @return string The rendered output of the shortcode
 */
function sc_component_fullwidth_quote($atts) {
	extract( shortcode_atts( array(
		'quote' => 'Quote text goes here',
		'author' => 'Anonymous',
		'bg_color' => '',
		'indented' => '',
		'css_classes' => ['fullwidth-quote'],
	), $atts ));

	if ($indented !== '') {
		$css_classes[] = $indented;
	}
	if ($bg_color !== '') {
		$css_classes[] = $bg_color;
	}

	return render_component('fullwidth-quote', [
		'css_classes' => implode(' ', $css_classes),
		'quote' => $quote,
		'author' => $author,
	]);
}
add_shortcode('fullwidth_quote', 'sc_component_fullwidth_quote');

if( function_exists('vc_map')) {
	/**
	 * Visual Composer Plugin definition
	 */
	vc_map(array(
		'name' => __('Full-width Quote'),
		'base' => 'fullwidth_quote',
		'icon' => 'fa fa-2x fa-quote-right',
		'description' => __('As seen in Callouts'),
		'category' => __('IUSM Components'),
		'params' => array(
			array(
				'type' => 'textarea',
				'heading' => __('Quote'),
				'param_name' => 'quote',
				'value' => '',
				'description' => __('Enter the quote text here')
			),
			array(
				'type' => 'textarea',
				'heading' => __('Quote Author'),
				'param_name' => 'author',
				'value' => '',
				'description' => __('Enter the quote author\'s name here')
			),
			array_merge($vc_shared_params_iu_bg_colors, [
				'description' => __('Select the block background color.'),
			]),
			array(
				'type' => 'dropdown',
				'heading' => __('Indent text'),
				'param_name' => 'indented',
				'value' => array(
					'No' => '',
					'Yes' => 'indented',
				),
				'description' => __('Pushes the block content inward on the left side'),
				'std' => '',
			),
		)
	));
}
