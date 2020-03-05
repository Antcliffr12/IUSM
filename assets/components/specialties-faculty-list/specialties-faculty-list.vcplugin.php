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
function sc_iu_specialties_faculty_list($atts) {
	extract( shortcode_atts( array(
		'division_code' => 'IN-****',
		'department_code' => 'IN-MDEP',
		'category' => 'IU-MDEP',
	), $atts, 'iu_specialties_faculty_list' ));

	// Load Faculty Data API
	require_once('FacultyData.php');

	$markup = '';

	try {
		$faculty = IU\FacultyData::getListBySubDepartment($department_code, $division_code, $category);
		$markup = render_component('specialties-faculty-list', ['faculty' => $faculty]);
	} catch (Exception $ex) {
		$markup .= "<div class=\"alert alert-danger\" role=\"alert\">{$ex->getMessage()}</div>\n";
	}
	return $markup;
}
add_shortcode('iu_specialties_faculty_list', 'sc_iu_specialties_faculty_list');


if( function_exists('vc_map')) {
	/**
	 * Visual Composer Plugin definition
	 */
	vc_map(array(
		'base' => 'iu_specialties_faculty_list',
		'name' => __('Specialty Department Faculty List', ''),
		'icon' => THEME_PATH . '/assets/images/icons/list.png',
		'description' => 'Displays a listing of faculty members',
		'category' => 'IUSM Components',
		'params' => array(
			array(
				'heading' => 'Division Code',
				'description' => '',
				'type' => 'textfield',
				'value' => 'IN-****',
				'param_name' => 'division_code',
			),
			array(
				'heading' => 'Department Code',
				'description' => '',
				'type' => 'textfield',
				'value' => 'IN-MDEP',
				'param_name' => 'department_code',
			),
			array(
				'heading' => 'Category',
				'description' => '',
				'type' => 'dropdown',
				'value' => array(
					'Basic Sciences' => 0,
					'Clinical Sciences' => 1,
				),
				'std' => 1,
				'param_name' => 'category',
			),
		)
	));
}
