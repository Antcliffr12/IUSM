<?php
/**
 * Single image above a linked title
 */

// Register shortcode
function sc_iu_content_grid_item_a( $atts ) {

	extract( shortcode_atts( array(
		'image' => false,
		'image_data' => [
			'url' => 'https://placeholdit.imgix.net/~text?txtsize=60&bg=CCCCCC&txtclr=444444&txt=ITEM+IMAGE&w=480&h=320',
		],
		'title' => 'Title Goes Here',
		'title_link' => '/',
	), $atts ));

	if ($image) {
		$img_id = preg_replace( '/[^\d]/', '', $image );
		$data = wp_get_attachment_image_src( $img_id, 'iu-large' );
		$image_data['url'] = $data[0];
	}

	return render_component('iu-content-grid-item:variant_a', [
		'image_data' => $image_data,
		'title' => $title,
		'title_link' => $title_link,
	]);

}
add_shortcode( 'iu_content_grid_item_a', 'sc_iu_content_grid_item_a' );

// Register shortcode class
if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_IU_Content_Grid_Item_A extends WPBakeryShortCode {}
}

// Register Visual Composer plugin
if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('Fullwidth Component 4', ''),
		'base' => 'iu_content_grid_item_a',
		'as_child' => array('only' => 'iu_content_grid_a'),
		'content_element' => true,
		'icon' => THEME_PATH . '/assets/images/icons/call-to-action.png',
		'description' => __('Image above linked title', ''),
		'category' => __('Content Grid Items', ''),
		'params' => array(

			array(
				'type' => 'attach_image',
				'heading' => __('Image', 'js_composer'),
				'param_name' => 'image',
				'value' => '',
				'description' => __('Select image from media library.', 'js_composer'),
				'admin_label' => true,
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

		)
	));
}
