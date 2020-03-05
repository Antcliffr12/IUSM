<?php
/**
 * Shortcode and Visual Composer plugin definition for component
 *
 */

function floating_panel($atts) {
    extract( shortcode_atts( array(
        'title' => 'Title Goes Here',
        'body' => 'Content Goes Here',
        'panel_title' => 'Panel Title Goes Here',
        'panel_body' => 'Panel Body Goes Here',
        'panel_button_text' => '',
        'panel_button_link' => '',
        'panel_alert' => '',
        'indented' => '',
    ), $atts ));

    return render_component('floating-panel', [
        'title' => $title,
        'body' => $body,
        'panel_title' => $panel_title,
        'panel_body' => $panel_body,
        'panel_button_text' => $panel_button_text,
        'panel_button_link' => $panel_button_link,
        'panel_alert' => $panel_alert,
        'indented' => $indented,
    ]);
}
add_shortcode('floating-panel', 'floating_panel');


if( function_exists('vc_map')) {
	/**
	 * Visual Composer Plugin definition
	 */
	vc_map(array(
		'name' => __('Content Block with Floated Side Panel', ''),
		'base' => 'floating-panel',
		'icon' => 'fa fa-ban fa-2x',
		'description' => __('DEPRECATED: Replaced by Callout Box'),
		'category' => __('Deprecated Components'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'h2',
				'heading' => __('Title', ''),
				'param_name' => 'title',
				'value' => '',
				'description' => __('Enter a title here', '')
			),
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => __('Text', ''),
				'param_name' => 'body',
				'value' => '',
				'description' => __('Enter content here', '')
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
				'type' => 'textfield',
				'holder' => 'h2',
				'heading' => __('Title', ''),
				'param_name' => 'panel_title',
				'value' => '',
				'group' => 'Panel',
				'description' => __('Enter a title here', '')
			),
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'heading' => __('Text', ''),
				'param_name' => 'panel_body',
				'value' => '',
				'group' => 'Panel',
				'description' => __('Enter content here', '')
			),
			array(
				'type' => 'textfield',
				'heading' => __('Button Text', ''),
				'param_name' => 'panel_button_text',
				'value' => '',
				'group' => 'Panel',
				'description' => __('Enter Button Text. Link will not show if left empty.', '')
			),
			array(
				'type' => 'textfield',
				'heading' => __('Button Link', ''),
				'param_name' => 'panel_button_link',
				'value' => '',
				'group' => 'Panel',
				'description' => __('Enter link. Link will not show if left empty.', '')
			),
			array(
				'type' => 'dropdown',
				'heading' => __('Alert Version', 'js_composer'),
				'param_name' => 'panel_alert',
				'value' => array(
					'false',
					'true',
				),
				'group' => 'Panel',
				'description' => __('Sets block as an alert.', 'js_composer'),
				'std' => '',
			),


		)
	));
}
