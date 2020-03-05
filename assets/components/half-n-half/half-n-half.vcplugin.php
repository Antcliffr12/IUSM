<?php
/**
 * Shortcode and Visual Composer plugin definition for component
 *
 */

/**
 * Shortcode processor for "Half-n-Half"
 * @param $atts Shortcode attribute array
 * @return string The rendered output of the shortcode
 */
function sc_component_half_n_half( $atts, $content = '' ) {

	global $wp_embed;

	extract( shortcode_atts( array(
		'image' => false,
        'image_url' => 'http://placehold.it/960x480',
		'video' => '&nbsp;',
		'title' => '',
		'buttons' => '',
		'placement' => 'img-left',
	), $atts ));

	$body = do_shortcode($content);

	$buttons = iusm_get_valid_items($buttons, 'button_link');

	if ($video != '&nbsp;') {
		$video = $wp_embed->run_shortcode('[embed class="dumb"]'. $video .'[/embed]');
	} else if ($image) {
		$img_id = preg_replace( '/[^\d]/', '', $image );
		$data = wp_get_attachment_image_src( $img_id, 'iu-extra-large');
		$image_url = $data[0];
	}

	return render_component('half-n-half', [
		'video' => $video,
		'image_url' => $image_url,
		'title' => $title,
		'body' => $body,
		'buttons' => $buttons,
		'placement' => $placement,
	]);
}
add_shortcode( 'half_n_half', 'sc_component_half_n_half' );

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Half_N_Half extends WPBakeryShortCodesContainer {}
}

/**
 * Visual Composer Plugin definition
 */
if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('Fullwidth Component 5 & 7', ''),
		'base' => 'half_n_half',
		'is_container' => true,
		'content_element' => true,
		'icon' => THEME_PATH . '/assets/components/half-n-half/vc-icon.png',
		'description' => __('Fullwidth 5, 7'),
		'category' => __('IUSM Components'),
		'js_view' => 'VcColumnView',
		'params' => array(
			array(
				'type' => 'attach_image',
				'heading' => __('Image'),
				'param_name' => 'image',
				'value' => '',
				'description' => __('Select image from media library.'),
			),
			array(
				'type' => 'textfield',
				'heading' => __('Video link'),
				'param_name' => 'video',
				'value' => '',
				'admin_label' => true,
				'description' => sprintf(__('If you want to use a video instead of an image, enter the link to the video here. (Note: read more about available formats at WordPress <a href="%s" target="_blank">codex page</a>).'), 'http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F'),
			),
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
				'heading' => __('Body Content (Basic)', ''),
				'param_name' => 'content',
				'value' => '',
				'description' => __('For simple body content, place text here instead of nesting interior content elements.', '')
			),
			array_merge($vc_shared_params_iu_buttons_group, ['group' => '',]),
			array(
				'type' => 'dropdown',
				'heading' => __('Image placement'),
				'param_name' => 'placement',
				'value' => array(
					__('On Left', 'js_composer') => 'img-left',
					__('On Right', 'js_composer') => 'img-right',
				),
				'description' => __('Set image placement.'),
				'std' => 'img-left',
			),
		)
	));
}
