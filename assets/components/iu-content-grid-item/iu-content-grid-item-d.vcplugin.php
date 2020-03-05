<?php
/**
 * Image with linked title and multi-line contact info
 */

// Register shortcode
function sc_iu_content_grid_item_d( $atts ) {

	extract( shortcode_atts( array(
		'image' => false,
		'image_data' => [
			'url' => 'https://placeholdit.imgix.net/~text?txtsize=60&bg=CCCCCC&txtclr=444444&txt=ITEM+IMAGE&w=480&h=320',
		],
		'title' => 'Title Goes Here',
		'title_link' => '/',
		'body' => "Facility or Location Name\n
9876 East South Street, Suite 1234\n
Cityname, IN 55555\n
555-555-5555\n",
		'extra1' => 'Firstname Lastname',
		'extra2' => 'Position Title',
	), $atts ));

	if ($image) {
		$img_id = preg_replace( '/[^\d]/', '', $image );
        $data = wp_get_attachment_image_src( $img_id, 'iu-large' );
		$image_data['url'] = $data[0];
	}

	return render_component('iu-content-grid-item:variant_d', [
		'image_data' => $image_data,
		'title' => $title,
		'title_link' => $title_link,
		'body' => $body,
		'extra1' => $extra1,
		'extra2' => $extra2,
	]);

}
add_shortcode( 'iu_content_grid_item_d', 'sc_iu_content_grid_item_d' );

// Register shortcode class
if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_IU_Content_Grid_Item_D extends WPBakeryShortCode {}
}

// Register Visual Composer plugin
if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('Grid Item Type D', ''),
		'base' => 'iu_content_grid_item_d',
		'as_child' => array('only' => 'iu_content_grid_d'),
		'content_element' => true,
		'icon' => THEME_PATH . '/assets/images/icons/call-to-action.png',
		'description' => __('Image with linked title and multi-line contact info', ''),
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
				"value" => "",
				'admin_label' => true,
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
				"heading" => __("Body Text", ""),
				"param_name" => "body",
				"value" => "",
				"description" => __("Enter the body text here", "")
			),
			array(
				"type" => "textfield",
				"heading" => __("Extra Info Title"),
				"param_name" => "extra1",
				"value" => "",
			),
			array(
				"type" => "textfield",
				"heading" => __("Extra Info Subtitle"),
				"param_name" => "extra2",
				"value" => "",
			),
		)
	));
}