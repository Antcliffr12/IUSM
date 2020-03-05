<?php
/**
 * Shortcode and Visual Composer plugin definition for component
 *
 */

/**
 * Shortcode processor for Link Button Grid
 * @param $atts Shortcode attribute array
 * @return string The rendered output of the shortcode
 */
function sc_iu_link_button_grid($atts, $content = '') {

	extract( shortcode_atts( array(
		'title' => '',
		'items_raw' => '',
		'columns' => 3,
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

	return render_component('iu-link-button-grid', [
		'title' => $title,
		'intro' => $content,
		'columns' => $columns,
		'items' => $items,
	]);
}
add_shortcode('iu_link_button_grid', 'sc_iu_link_button_grid');

// Register shortcode class
if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_IU_Link_Button_Grid extends WPBakeryShortCode {}
}

// Register Visual Composer plugin
if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('Link Button Grid', ''),
		'base' => 'iu_link_button_grid',
		'icon' => THEME_PATH . '/assets/components/iu-link-button-grid/vc-icon.png',
		'description' => __('Displays a grid of links as colored boxes', ''),
		'category' => __('IUSM Components'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'h2',
				'heading' => __('Title', ''),
				'param_name' => 'title',
				'value' => '',
				'description' => __('Optional title text to be displayed above the grid items.', '')
			),
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => __('Description', ''),
				'param_name' => 'content',
				'value' => '',
				'description' => __('Optional description text to be displayed above the grid items.')
			),
			array(
				'type' => 'param_group',
				'value' => '',
				'heading' => __('Grid Items'),
				'param_name' => 'items',
				'description' => __('Add items to the grid'),
				'params' => array_merge($vc_shared_params_iu_link_buttons, []),
			),
			array(
				'type' => 'dropdown',
				'heading' => __('Grid Layout', ''),
				'param_name' => 'columns',
				'value' => array(
					__('2 Columns', '') => 2,
					__('3 Columns', '') => 3,
					__('4 Columns', '') => 4,
				),
				'description' => __('Select the number of columns this grid will use at the largest screen size.', ''),
				'std' => 3,
			),
		)
	));
}