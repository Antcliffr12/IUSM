<?php
/**
 * Shortcode and Visual Composer plugin definition for component
 *
 */

function sc_iu_feature_block($atts, $content = '') {

    extract( shortcode_atts( array(
        'title' => '',
        'image' => false,
        'image_url' => 'http://placehold.it/360x240',
        'subtitle' => '',
        'classes' => ['iu-feature-block'],
    ), $atts ));

    if ($image) {
        $img_id = preg_replace( '/[^\d]/', '', $image );
        $data = wp_get_attachment_image_src( $img_id, 'iu-medium');
        $image_url = $data[0];
    }

    if ($title != '') {
        $classes[] = 'has-main-title';
    }

    return render_component('iu-feature-block', [
        'classes' => implode(' ', $classes),
        'title' => $title,
        'image_url' => $image_url,
        'subtitle' => $subtitle,
        'body' => $content,
    ]);
}
add_shortcode('iu_feature_block', 'sc_iu_feature_block');

/**
 * Visual Composer Plugin definition
 */
if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('Split Component 16'),
		'base' => 'iu_feature_block',
		'icon' => THEME_PATH . '/assets/components/iu-feature-block/vc-icon.png',
		'description' => __('2-Column #16'),
		'category' => __('IUSM Components'),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __('Header Title'),
				'param_name' => 'title',
				'value' => '',
				'description' => __('Enter header title here. Leave empty to omit.')
			),
			array(
				'type' => 'attach_image',
				'value' => '',
				'heading' => 'Image',
				'param_name' => 'image',
				'admin_label' => true,
			),
			array(
				'type' => 'textfield',
				'holder' => 'h3',
				'heading' => __('Subtitle', ''),
				'param_name' => 'subtitle',
				'value' => '',
				'description' => __('Enter a subtitle here.')
			),
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => __('Text', ''),
				'param_name' => 'content',
				'value' => '',
				'description' => __('Enter content here.')
			),
		)
	));
}
