<?php
/**
 * Floated image, linked title, subtitle, intro text
 */

// Register shortcode
function sc_iu_content_grid_item_g( $atts ) {

    // Load Faculty Data API
	
	
	   extract(shortcode_atts(array(
            'uid' => '',
            'intro' => '',
        ), $atts));

	if(file_exists('FacultyData.php')) {
		require_once('FacultyData.php');    
            //$profile = new stdClass();
				$markup = '';
            try {
                //$profile = new IU\FacultyData($uid);
				$profile = IU\FacultyData::getFacultyResidents($uid);
				$markup = render_component('iu-content-grid-item:variant_g', ['profile' => $profile, 'intro' => $intro]);
				
            } catch (Exception $ex) {
                $markup .= "<div class=\"alert alert-danger\" role=\"alert\">{$ex->getMessage()}</div>\n";
            }				
			return $markup;
		}
        
}
add_shortcode( 'iu_content_grid_item_g', 'sc_iu_content_grid_item_g' );

// Register shortcode class
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_IU_Content_Grid_Item_G extends WPBakeryShortCode {}
}

// Register Visual Composer plugin
if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('Split Component 11', ''),
		'base' => 'iu_content_grid_item_g',
		'as_child' => array('only' => 'iu_content_grid_g'),
		'content_element' => true,
		'icon' => THEME_PATH . '/assets/images/icons/call-to-action.png',
		'description' => __('Grid variant that displays similar to Variant E, but outputs a single faculty member.', ''),
		'category' => __('Content Grid Items', ''),
		'params' => array(
			array(
				"type" => "textfield",
				"heading" => __("UID", ""),
				"param_name" => "uid",
				'admin_label' => true,
				"value" => "",
				"description" => __("UID for faculty member", "")
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
