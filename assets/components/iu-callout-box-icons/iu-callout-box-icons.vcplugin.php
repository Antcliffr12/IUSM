<?php
/**
 * Shortcode and Visual Composer plugin definition for component
 *
 */

function sc_iu_callout_box_icons($atts, $content = '') {

	extract( shortcode_atts( array(
		'title' => '',
		'buttons' => '',
		'button_text' => '',
		'button_link' => '',
		'style' => 'callout-normal bg-iu-limestone',
		'position' => '',
		'classes' => ['iu-callout-box'],
		'extra_classes' => '',
	), $atts ));

	$buttons = iusm_get_valid_items($buttons, 'button_link');
	if ($button_link != '') {
		$buttons = array_unshift($buttons, array('button_link' => $button_link, 'button_text' => $button_text));
	}

	if ($extra_classes != '') {
		$classes[] = $extra_classes;
	}
	if ($position != '') {
		$classes[] = $position;
	}
	$classes[] = $style;

	return render_component('iu-callout-box-icons', [
		'title' => $title,
		'body' => $content,
		'buttons' => $buttons,
	   'css_classes' => implode(' ', $classes),
	]);
}
add_shortcode('iu_callout_box_icons', 'sc_iu_callout_box_icons');

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_IU_Callout_Box_Icons extends WPBakeryShortCode {}
}


/**
 * Visual Composer Plugin definition
 */
if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('Callout Box Icons', ''),
		'base' => 'iu_callout_box_icons',
		'icon' => THEME_PATH . '/assets/components/iu-callout-box/vc-icon.png',
		'description' => __('Provides all callouts except the quote block', ''),
		'category' => __('IUSM Components'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'h2',
				'heading' => __('Title', ''),
				'param_name' => 'title',
				'value' => '',
				'group' => 'Content',
				'description' => __('Enter a title here', '')
			),
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => __('Body Content', ''),
				'param_name' => 'content',
				'value' => '',
				'group' => 'Content',
				'description' => __('Enter content here', '')
			),
			array_merge($vc_shared_params_iu_buttons_group, []),
			array(
				'type' => 'dropdown',
				'heading' => __('Appearance'),
				'param_name' => 'style',
				'value' => array(
					'Normal' => 'callout-normal bg-iu-cream',
					'Alert' => 'callout-alert bg-iu-crimson',
					'Warning' => 'callout-warning bg-iu-gold',
					'Call-to-Action' => 'callout-cta bg-iu-crimson',
					'Indented Call-to-Action' => 'callout-cta bg-iu-crimson indented',
					'Promo' => 'callout-promo bg-iu-crimson',
					'Indented Promo' => 'callout-promo bg-iu-crimson indented',
				),
				'group' => 'Display',
				'description' => __('Choose the visual appearance of the callout. You can combine this with the settings on the parent IU Section Block to create a large variety of displays.'),
				'std' => 'callout-normal',
			),
			array(
				'type' => 'dropdown',
				'heading' => __('Positioning'),
				'param_name' => 'position',
				'value' => array(
					'Normal (Expand)' => '',
					'Floated Left' => 'pull-left',
					'Floated Right' => 'pull-right',
				),
				'group' => 'Display',
				'description' => __('Set to "Normal" to make callout box expand to fill container (used for full-width callout sections or when callout is in its own column). Select a Floated presentation when the callout element is directly adjacent to a main element (it should be placed just before the main element)'),
				'std' => '',
			),
			array(
				'type' => 'textfield',
				'heading' => __('Additional CSS Classes'),
				'param_name' => 'extra_classes',
				'value' => '',
				'group' => 'Display',
				'description' => __('Optional space-separated list of CSS class names to apply to this element.')
			),


		)
	));
}
