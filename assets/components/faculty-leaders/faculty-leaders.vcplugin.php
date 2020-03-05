<?php
/**
 * Shortcode and Visual Composer plugin definition for component
 *
 */

/**
 * Shortcode processor for faculty-list
 * @param $atts Shortcode attribute array
 * @return string The rendered output of the shortcode
 */
function sc_iu_faculty_leaders($atts) {
	extract( shortcode_atts( $atts, 'iu_faculty_leaders' ));

	// Load Faculty Data API
	require_once('FacultyData.php');

	$markup = '';

	try {
		$faculty = IU\FacultyData::getExecutiveList();
		$markup = render_component('faculty-leaders', ['faculty' => $faculty]);
	} catch (Exception $ex) {
		$markup .= "<div class=\"alert alert-danger\" role=\"alert\">{$ex->getMessage()}</div>\n";
	}
	return $markup;
}
add_shortcode('iu_faculty_leaders', 'sc_iu_faculty_leaders');

if( function_exists('vc_map')) {
	/**
	 * Visual Composer Plugin definition
	 */
	vc_map(array(
		'base' => 'iu_faculty_leaders',
		'name' => __('Executive Leaders', ''),
		'icon' => THEME_PATH . '/assets/images/icons/list.png',
		'description' => 'Displays a listing of faculty leaders',
		'category' => 'IUSM Components'
	));

}