<?php
/**
 * Testimonials
 */

// Register shortcode
function sc_iu_testimonials_item( $atts ) {

	extract( shortcode_atts( array(
		'image' => false,
		'image_data' => [
			'url' => 'https://placeholdit.imgix.net/~text?txtsize=60&bg=CCCCCC&txtclr=444444&txt=ITEM+IMAGE&w=480&h=320',
		],
		'title' => 'Title Goes Here',
		'title_link' => '/',
		'intro' => 'Lorem ipsum dolor sit amet, movet eleifend consectetuer usu ad, ei quo dissentiunt instructior, has nulla accusam temporibus et.',

	), $atts ));

	if ($image) {
		$img_id = preg_replace( '/[^\d]/', '', $image );
        $data = wp_get_attachment_image_src( $img_id, 'iu-large' );
		$image_data['url'] = $data[0];
	}

	return render_component('iu-testimonials-item', [
		'columns' => $columns,
		'image_data' => $image_data,
		'title' => $title,
		'title_link' => $title_link,
		'intro' => $intro,
	]);

}
add_shortcode( 'iu_testimonials_item', 'sc_iu_testimonials_item' );

// Register shortcode class
if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_iu_testimonials_item extends WPBakeryShortCode {}
}

// Register Visual Composer plugin
if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('IU Testimonials', ''),
		'base' => 'iu_testimonials_item',
		'as_child' => array('only' => 'iu_testimonials'),
		'content_element' => true,
		'icon' => THEME_PATH . '/assets/images/icons/call-to-action.png',
		'description' => __('Image with linked title and intro text', ''),
		'category' => __('Content Grid Items', ''),
		'params' => array(
			array(
				'type' => 'attach_image',
				'heading' => __('Image', 'js_composer'),
				'param_name' => 'image',
				'value' => '',
				'description' => __('Select image from media library.', 'js_composer'),
				'admin_label' => true
			),
			array(
				"type" => "textfield",
				"heading" => __("Title", ""),
				"param_name" => "title",
				'admin_label' => true,
				"value" => "",
				"description" => __("Title text for the grid item", "")
			),
			array(
				"type" => "textfield",
				"heading" => __("Link", ""),
				"param_name" => "title_link",
				"value" => "",
				"description" => __('Provide the link for the title text', "")
			),
			array(
				"type" => "textarea",
				"heading" => __("Intro Text", ""),
				"param_name" => "intro",
				"value" => "",
				"description" => __("Enter the intro text here", "")
			),

		)
	));
}
