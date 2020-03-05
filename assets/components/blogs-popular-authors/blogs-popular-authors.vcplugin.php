<?php


// Register shortcode
function blogs_popular_authors_faculty( $atts ) {

    extract(shortcode_atts(array(
        'uid' => '',
        'intro' => '',
    ), $atts, 'blogs-popular-authors'));

    require_once('FacultyData.php');


    return render_component('blogs-popular-authors', [
        'intro' => $intro,
        'uid' => $uid,
    ]);

}
add_shortcode( 'blogs-popular-authors', 'blogs_popular_authors_faculty' );


if(function_exists('vc_map')){
  vc_map(array(
    'name' => 'Popular Blogs Authors',
    'base' => 'blogs-popular-authors',
    'description' => __('Allows to add faulty to popular blog'),
    'params' => array(
			array(
				"type" => "textfield",
				"heading" => __("UID", ""),
				"param_name" => "uid",
				"value" => '',
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
