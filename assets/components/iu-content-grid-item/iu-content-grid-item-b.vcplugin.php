<?php
/**
 * Single image above a linked title and intro text
 */

// Register shortcode
function sc_iu_content_grid_item_b( $atts ) {

	extract( shortcode_atts( array(
		'image' => false,
		'image_data' => [
			'url' => 'https://via.placeholder.com/480x320',
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

	return render_component('iu-content-grid-item:variant_b', [
		'image_data' => $image_data,
		'title' => $title,
		'title_link' => $title_link,
		'intro' => $intro,
	]);

}
add_shortcode( 'iu_content_grid_item_b', 'sc_iu_content_grid_item_b' );

// Register shortcode class
if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_IU_Content_Grid_Item_B extends WPBakeryShortCode {}
}

// Register Visual Composer plugin
if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('Split Component 4 & 5', ''),
		'base' => 'iu_content_grid_item_b',
		'as_child' => array('only' => 'iu_content_grid_b'),
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
