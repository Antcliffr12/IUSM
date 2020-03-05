<?php
/**
 * Single image above a title
 */

// Register shortcode
function sc_iu_content_grid_item_c( $atts, $content = '' ) {

	extract( shortcode_atts( array(
		'image' => false,
		'image_data' => [
			'url' => 'https://placeholdit.imgix.net/~text?txtsize=60&bg=CCCCCC&txtclr=444444&txt=ITEM+IMAGE&w=480&h=320',
		],
		'title' => 'Title Goes Here',
	), $atts ));

	if ($image) {
		$img_id = preg_replace( '/[^\d]/', '', $image );
        $data = wp_get_attachment_image_src( $img_id, 'iu-large' );
		$image_data['url'] = $data[0];
	}

	// Creates a semi random id for aria aria-describedby controls for WAI compliance.
	$titleRefId = '';
	if(!empty($title)){
		$title_bits = explode(' ', $title);
		foreach($title_bits as $bit){
			$titleRefId .= strtolower($bit);
		}
		$titleRefId .= strlen($titleRefId);
	}


	return render_component('iu-content-grid-item:variant_c', [
		'image_data' => $image_data,
		'title' => $title,
		'titleRefId' => $titleRefId,
	    'intro' => $content,
	]);
}
add_shortcode( 'iu_content_grid_item_c', 'sc_iu_content_grid_item_c' );

// Register shortcode class
if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_IU_Content_Grid_Item_C extends WPBakeryShortCode {}
}

// Register Visual Composer plugin
if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('Fullwidth Component 15', ''),
		'base' => 'iu_content_grid_item_c',
		'as_child' => array('only' => 'iu_content_grid_c'),
		'content_element' => true,
		'icon' => THEME_PATH . '/assets/images/icons/call-to-action.png',
		'description' => __('Image above title text', ''),
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
				"type" => "textarea_html",
				"heading" => __("Intro Text", ""),
				"param_name" => "content",
				"value" => "",
				"description" => __("Enter the intro text here", "")
			),

		)
	));
}
