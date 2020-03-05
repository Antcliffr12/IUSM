<?php
/**
 * Shortcode and Visual Composer plugin definition for component
 *
 */

/**
 * Shortcode processor for Link Button List
 * @param $atts Shortcode attribute array
 * @return string The rendered output of the shortcode
 */
function sc_iu_link_button_list($atts) {

	extract( shortcode_atts( array(
		'items_raw' => '',
		'items' => '',
	), $atts ));

	$items = iusm_get_valid_items($items, 'link');
	$parsed_items = array();

	if ($items_raw != '') {
		foreach (explode(",", $items_raw) as $line) {
			$elements = explode('|', $line);
			$parsed_items[] = array('label' => $elements[0], 'link' => $elements[1]);
		}
	}

	$items = array_merge($parsed_items, $items);

	return render_component('iu-link-button-list', [
		'items' => $items,
	]);
}
add_shortcode('iu_link_button_list', 'sc_iu_link_button_list');

// Register shortcode class
if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_IU_Link_Button_List extends WPBakeryShortCode {}
}

// Register Visual Composer plugin
if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('Link Button List', ''),
		'base' => 'iu_link_button_list',
		'icon' => THEME_PATH . '/assets/components/iu-link-button-list/vc-icon.png',
		'description' => __('Displays a list of links as colored boxes', ''),
		'category' => __('IUSM Components'),
		'params' => array(
			array(
				'type' => 'param_group',
				'value' => '',
				'heading' => __('List Items'),
				'param_name' => 'items',
				'description' => __('Add items to the list'),
				'params' => array_merge($vc_shared_params_iu_link_buttons, []),
			),
		),
	));
}