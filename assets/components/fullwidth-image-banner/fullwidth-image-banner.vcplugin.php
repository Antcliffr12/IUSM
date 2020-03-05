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
function sc_component_fullwidth_image_banner($atts, $content = '') {
    extract( shortcode_atts( array(
        'image' => false,
        'image_url' => 'http://placehold.it/1920x960',
    ), $atts ));

    if ($image) {
        $img_id = preg_replace( '/[^\d]/', '', $image );
        $data = wp_get_attachment_image_src( $img_id, 'iu-massive' );
        $image_url = $data[0];
    }

    return render_component('fullwidth-image-banner', [
        'image_url' => $image_url,
        'overlay_text' => $content,
    ]);
}
add_shortcode('fullwidth_image_banner', 'sc_component_fullwidth_image_banner');

if( function_exists('vc_map')) {
	/**
	 * Visual Composer Plugin definition
	 */
	vc_map(array(
		'name' => __('Full-width Image Banner'),
		'base' => 'fullwidth_image_banner',
		'icon' => 'icon-wpb-single-image',
		'description' => __('Displays a full-width banner image with overlay text'),
		'category' => __('IUSM Components'),
		'params' => array(
			array(
				'type' => 'attach_image',
				'heading' => __('Image', 'js_composer'),
				'param_name' => 'image',
				'value' => '',
				'description' => __('Select an image from media library.'),
				'admin_label' => true
			),
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => __('Overlay Text'),
				'param_name' => 'content',
				'value' => '',
				'description' => __('Enter text that will be displayed on the banner overlay')
			),
		)
	));
}
