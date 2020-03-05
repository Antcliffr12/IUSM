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
function sc_iu_faculty_list($atts) {
	extract( shortcode_atts( array(
		'department_code' => 'IU-****',
		'category' => 'IU-MDEP',
	), $atts, 'iu_faculty_list' ));

	// Load Faculty Data API
	if(file_exists('FacultyData.php')) {

		require_once('FacultyData.php');
		$markup = '';
		try {
			$faculty = IU\FacultyData::getListByDepartment($department_code, $category);
			$markup = render_component('faculty-list', ['faculty' => $faculty]);
		} catch (Exception $ex) {
			$markup .= "<div class=\"alert alert-danger\" role=\"alert\">{$ex->getMessage()}</div>\n";
		}
		return $markup;
	}
}
add_shortcode('iu_faculty_list', 'sc_iu_faculty_list');


if( function_exists('vc_map')) {
	/**
	 * Visual Composer Plugin definition
	 */
	vc_map(array(
		'base' => 'iu_faculty_list',
		'name' => __('Department Faculty List', ''),
		'icon' => THEME_PATH . '/assets/images/icons/list.png',
		'description' => 'Displays a listing of faculty members',
		'category' => 'IUSM Components',
		'params' => array(
			array(
				'heading' => 'Department Code',
				'description' => '',
				'type' => 'textfield',
				'value' => 'IU-****',
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