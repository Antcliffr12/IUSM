<?php

function fullwidth_promo_with_button($atts) {
    extract( shortcode_atts( array(
        'title' => 'Title Goes Here',
        'body' => 'Content Goes Here',
        'button_text' => 'Enter Button Text',
        'button_link' => '#',
        'link_logo' => '',
        'bg_color' => 'bg-iu-crimson',
        'indented' => '',
    ), $atts ));


    return render_component('fullwidth-promo-with-button', [
        'title' => $title,
        'body' => $body,
        'button_text' => $button_text,
        'button_link' => $button_link,
        'link_logo' => $link_logo,
        'bg_color' => $bg_color,
        'indented' => $indented,
    ]);
}
add_shortcode('fullwidth-promo-with-button', 'fullwidth_promo_with_button');

if( function_exists('vc_map')) {
	/**
	 * Visual Composer Plugin definition
	 */
	vc_map(array(
		"name" => __("Full-width Promo With Button", ""),
		"base" => "fullwidth-promo-with-button",
		'icon' => 'fa fa-ban fa-2x',
		'description' => __('DEPRECATED: Replaced by Callout Box'),
		'category' => __('Deprecated Components'),
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __("Title", ""),
				"param_name" => "title",
				"value" => "",
				"description" => __("Enter a title here", "")
			),
			array(
				"type" => "textarea",
				"heading" => __("Body", ""),
				"param_name" => "body",
				"value" => "",
				"description" => __("Enter a body content", "")
			),


			array(
				"type" => "textfield",
				"heading" => __("Button Text", ""),
				"param_name" => "button_text",
				"value" => "",
				"description" => __("Enter Button Text", "")
			),
			array(
				"type" => "textfield",
				"heading" => __("Button Link", ""),
				"param_name" => "button_link",
				"value" => "",
				"description" => __("Enter link", "")
			),

			array(
				"type" => "dropdown",
				"heading" => __("Add IU Logo", ""),
				"param_name" => "link_logo",
				'value' => array(
					'false',
					'true',
				),
				"description" => __("Adds the IU Logo left of button text", "")
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
