<?php
/**
 * Shortcode and Visual Composer plugin definition for component
 *
 */

/**
 * Shortcode processor for {mycomponent}
 * @param $atts Shortcode attribute array
 * @return string The rendered output of the shortcode
 */
function sc_iu_text_with_floated_image($atts, $content = '') {
	extract( shortcode_atts( array(
		'image' => false,
        'image_url' => 'http://placehold.it/360x240',
		'title' => '',
		'title_element' => 'h2',
		'buttons' => '',
		'classes' => ['iu-text-block has-floated-img'],
		'extra_classes' => '',
		'placement' => 'img-left',
	), $atts ));

	$buttons = iusm_get_valid_items($buttons, 'button_link');

	if ($image) {
		$img_id = preg_replace( '/[^\d]/', '', $image );
		$data = wp_get_attachment_image_src( $img_id, 'iu-medium');
		$image_url = $data[0];
	}

	if (!empty($extra_classes)) {
		$classes[] = $extra_classes;
	}

	$classes[] = $placement;

	return render_component('iu-text-with-floated-image', [
		'css_classes' => implode(' ', $classes),
		'image_url' => $image_url,
		'title' => $title,
		'title_element' => $title_element,
		'body' => $content,
		'buttons' => $buttons,
	]);
}
add_shortcode('iu_text_with_floated_image', 'sc_iu_text_with_floated_image');

// Register shortcode class
if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_IU_Text_With_Floated_Image extends WPBakeryShortCode {}
}

// Register Visual Composer plugin
if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('Split Component 14 & 15', ''),
		'base' => 'iu_text_with_floated_image',
		'icon' => THEME_PATH . '/assets/components/iu-text-with-floated-image/vc-icon.png',
		'description' => __('Fullwidth #16'),
		'category' => __('IUSM Components', ''),
		'params' => array(
			array(
				'type' => 'attach_image',
				'heading' => __('Image'),
				'param_name' => 'image',
				'value' => '',
				'description' => __('Select image from media library.'),
			),
			array(
				'type' => 'dropdown',
				'heading' => __('Image placement'),
				'param_name' => 'placement',
				'value' => array(
					__('On Left') => 'img-left',
					__('On Right') => 'img-right',
				),
				'description' => __('Set image placement.'),
				'std' => 'img-left',
			),
			array(
				'type' => 'textfield',
				'holder' => 'h2',
				'heading' => __('Title'),
				'param_name' => 'title',
				'value' => 'Title',
				'description' => __('Enter a title here.', '')
			),
			array(
				'type' => 'dropdown',
				'heading' => __('Widget title element', 'js_composer'),
				'param_name' => 'title_element',
				'description' => __('Heading element for widget title.', 'js_composer'),
				'value' => array(
					__('Select Element') => '',
					__('H1', '') => 'h1',
					__('H2', '') => 'h2',
	
				),
			),
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => __('Body Text'),
				'param_name' => 'content',
				'value' => '',
				'description' => __('Enter text content here.', '')
			),
			array_merge($vc_shared_params_iu_buttons_group, [
				'group' => '',
			]),
			array(
				'type' => 'textfield',
				'heading' => __('Additional CSS Classes', ''),
				'param_name' => 'extra_classes',
				'value' => '',
				'group' => 'Customization',
				'description' => __('Optional space-separated list of CSS class names to apply to the container.', '')
			),

		)
	));
}
