<?php
/**
 * Shortcode and Visual Composer plugin definition for component
 *
 */

function stacked_panel($atts) {
    extract( shortcode_atts( array(
        'title' => '',
        'body' => '',
        'info_block_title' => 'Panel Title Goes Here',
        'info_block_body' => 'Panel Body Goes Here',
        'info_button_text' => '',
        'info_button_link' => '',
        'info_alert' => '',
        'indented' => '',
        'classes' => ['stacked-panel'],
    ), $atts ));

    if (isset($info_alert) && $info_alert == 'true') {
        $classes[] = 'is-alert';
    }
    if (isset($indented) && $info_alert == 'true') {
        $classes[] = 'indented';
    }

    return render_component('stacked-panel', [
        'title' => $title,
        'body' => $body,
        'info_block_title' => $info_block_title,
        'info_block_body' => $info_block_body,
        'info_button_text' => $info_button_text,
        'info_button_link' => $info_button_link,
        'classes' => implode(' ', $classes),
    ]);
}
add_shortcode('stacked-panel', 'stacked_panel');

/**
 * Visual Composer Plugin definition
 */
if( function_exists('vc_map')) {
	vc_map(array(
		"name" => __("Stacked Panel", ""),
		"base" => "stacked-panel",
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
				"heading" => __("Text", ""),
				"param_name" => "body",
				"value" => "",
				"description" => __("Enter content here", "")
			),
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


			array(
				"type" => "textfield",
				"heading" => __("Title", ""),
				"param_name" => "info_block_title",
				"value" => "",
				'group' => 'Panel',
				"description" => __("Enter a title here", "")
			),
			array(
				"type" => "textarea",
				"heading" => __("Text", ""),
				"param_name" => "info_block_body",
				"value" => "",
				'group' => 'Panel',
				"description" => __("Enter content here", "")
			),
			array(
				"type" => "textfield",
				"heading" => __("Button Text", ""),
				"param_name" => "info_button_text",
				"value" => "",
				'group' => 'Panel',
				"description" => __("Enter Button Text. Link will not show if left empty.", "")
			),
			array(
				"type" => "textfield",
				"heading" => __("Button Link", ""),
				"param_name" => "info_button_link",
				"value" => "",
				'group' => 'Panel',
				"description" => __("Enter link. Link will not show if left empty.", "")
			),

			array(
				'type' => 'dropdown',
				'heading' => __('Alert Version', 'js_composer'),
				'param_name' => 'info_alert',
				'value' => array(
					'false',
					'true',
				),
				'group' => 'Panel',
				'description' => __('Sets bottom info block as an alert.', 'js_composer'),
				'std' => '',
			),

		)
	));
}
