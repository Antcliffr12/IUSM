<?php
/**
 * Shortcode and Visual Composer plugin definition for component
 *
 */

/**
 * Shortcode processor for Split Columns A
 * @param $atts Shortcode attribute array
 * @return string The rendered output of the shortcode
 */
function sc_iu_split_columns_a($atts, $content = '') {

	extract( shortcode_atts( array(
		'col_1_title' => '',
		'col_1_simple_text' => '',
		'col_1_buttons' => '',
		'col_2_title' => '',
		'col_2_simple_text' => '',
		'col_2_buttons' => '',
		'classes' => ['iu-split-columns-a row'],
		'extra_classes' => '',
	), $atts ));

	$col_1_buttons = iusm_get_valid_items($col_1_buttons, 'button_link');
	$col_2_buttons = iusm_get_valid_items($col_2_buttons, 'button_link');

	$pattern = get_shortcode_regex();
	$matches = [];
	$col_1_content = [];
	$col_2_content = [];

	if (!empty($extra_classes)) {
		$classes[] = $extra_classes;
	}

	// Parse the content to shuffle specific shortcodes into specific columns
	if (preg_match_all('/'. $pattern .'/s', $content, $matches) && count($matches) > 0) {
		foreach ($matches[0] as $shortcode) {
			if (strpos($shortcode, '[vc_column_text') === 0) {
				$col_1_content[] = do_shortcode($shortcode);
				$content = str_replace($shortcode, '', $content);
				continue;
			}
			if (strpos($shortcode, '[iu_callout_box') === 0) {
				$col_2_content[] = do_shortcode($shortcode);
				$content = str_replace($shortcode, '', $content);
				continue;
			}
			if (strpos($shortcode, '[iu_link_button_list') === 0) {
				$col_2_content[] = do_shortcode($shortcode);
				$content = str_replace($shortcode, '', $content);
			}
		}
	}

	$opts = [
		'css_classes' => implode(' ', $classes),
		'col_1_title' => $col_1_title,
		'col_1_content' => $col_1_simple_text . implode("\n", $col_1_content),
		'col_1_buttons' => $col_1_buttons,
		'col_2_title' => $col_2_title,
		'col_2_content' => $col_2_simple_text . implode("\n", $col_2_content),
		'col_2_buttons' => $col_2_buttons,
	];

	return render_component('iu-split-columns-a', $opts);
}
add_shortcode('iu_split_columns_a', 'sc_iu_split_columns_a');

// Register shortcode class
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_IU_Split_Columns_A extends WPBakeryShortCodesContainer {}
}

/**
 * Visual Composer Plugin definition
 */
if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('Split Component 10'),
		'base' => 'iu_split_columns_a',
		'as_parent' => array('only' => 'vc_column_text,iu_link_button_list,iu_callout_box'),
		'is_container' => true,
		'content_element' => true,
		'icon' => THEME_PATH . '/assets/components/iu-split-columns-a/vc-icon.png',
		'description' => __('Fullwidth #6'),
		'category' => __('IUSM Components'),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __('Column 1 Title'),
				'param_name' => 'col_1_title',
				'holder' => 'h2',
				'value' => '',
				'group' => 'Column 1',
				'description' => __('Enter a title here')
			),
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'heading' => __('Column 1 Content (Basic)'),
				'param_name' => 'col_1_simple_text',
				'value' => '',
				'group' => 'Column 1',
				'description' => __('For simple body content, place text here instead of nesting interior content elements.')
			),
			array_merge($vc_shared_params_iu_buttons_group, [
				'heading' => __('Column 1 Buttons (optional)'),
				'param_name' => 'col_1_buttons',
				'group' => 'Column 1',
			]),
			array(
				'type' => 'textfield',
				'heading' => __('Column 2 Title'),
				'param_name' => 'col_2_title',
				'holder' => 'h2',
				'value' => '',
				'group' => 'Column 2',
				'description' => __('Enter a title here')
			),
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'heading' => __('Column 2 Content (Basic)'),
				'param_name' => 'col_2_simple_text',
				'value' => '',
				'group' => 'Column 2',
				'description' => __('For simple body content, place text here instead of nesting interior content elements.')
			),
			array_merge($vc_shared_params_iu_buttons_group, [
				'heading' => __('Column 2 Buttons (optional)'),
				'param_name' => 'col_2_buttons',
				'group' => 'Column 2',
			]),
			array(
				'type' => 'textfield',
				'heading' => __('Additional CSS Classes'),
				'param_name' => 'extra_classes',
				'value' => '',
				'group' => 'Customization',
				'description' => __('Optional space-separated list of CSS class names to apply to this element.')
			),
		)
	));
}
