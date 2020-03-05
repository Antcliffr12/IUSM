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
function sc_iu_resident_list($atts) {
	extract( shortcode_atts( array(
		'department_code' => 'IN-****',
	), $atts, 'iu_resident_list' ));

	// Load Faculty Data API
	require_once('ResidentData.php');

	$markup = '';

	try {
		$resident = IU\ResidentData::getResidentListByDepartment($department_code);
		$markup = render_component('resident-list', ['resident' => $resident]);
	} catch (Exception $ex) {
		$markup .= "<div class=\"alert alert-danger\" role=\"alert\">{$ex->getMessage()}</div>\n";
	}
	return $markup;
}
add_shortcode('iu_resident_list', 'sc_iu_resident_list');


if( function_exists('vc_map')) {
	/**
	 * Visual Composer Plugin definition
	 */
	vc_map(array(
		'base' => 'iu_resident_list',
		'name' => __('Resident List', ''),
		'icon' => THEME_PATH . '/assets/images/icons/list.png',
		'description' => 'Displays a listing of faculty members',
		'category' => 'IUSM Components',
		'params' => array(
			array(
				'heading' => 'Department Code',
				'description' => '',
				'type' => 'textfield',
				'value' => 'IN-****',
				'param_name' => 'department_code',
			),
		)
	));
}
