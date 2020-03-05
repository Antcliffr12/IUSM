<?php
/**
 * Shortcode and Visual Composer plugin definition for component
 *
 */

/**
 * Shortcode processor for Full-width Quote
 * @param $atts Shortcode attribute array
 * @return string The rendered output of the shortcode
 */
function sc_component_fullwidth_text_promo($atts) {
    extract( shortcode_atts( array(
        'body' => 'Promo body text goes here',
        'bg_color' => 'bg-iu-crimson',
        'indented' => '',
    ), $atts ));

    return render_component('fullwidth-text-promo', [
        'body' => $body,
        'bg_color' => $bg_color,
        'indented' => $indented,
    ]);
}
add_shortcode('fullwidth_text_promo', 'sc_component_fullwidth_text_promo');


	/**
	 * Visual Composer Plugin definition
	 */
if( function_exists('vc_map')) {
	vc_map(array(
		"name" => __("Full-width Text Promo", ""),
		"base" => "fullwidth_text_promo",
		'icon' => 'fa fa-ban fa-2x',
		'description' => __('DEPRECATED: Replaced by Callout Box'),
		'category' => __('Deprecated Components'),
		"params" => array(
			array(
				"type" => "textarea",
				"heading" => __("Text", ""),
				"param_name" => "body",
				"value" => "",
				"description" => __("Enter the promo body text here", "")
			),
			array_merge($vc_shared_params_iu_bg_colors, [
				'description' => __('Select the block background color.', ''),
				'std' => 'bg-iu-crimson',
			]),
			array(
				'type' => 'dropdown',
				'heading' => __('Indent text', 'js_composer'),
				'param_name' => 'indented',
				'value' => array(
					'false',
					'true',
				),
				'description' => __('Pushes the block content inward on the left side', 'js_composer'),
				'std' => '',
			),
		)
	));
}
