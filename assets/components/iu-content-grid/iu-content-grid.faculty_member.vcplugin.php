<?php
/**
 * Floated image, linked title, subtitle, intro text
 */

// Register shortcode
function sc_iu_content_grid_faculty( $atts ) {

	// Load Faculty Data API
	if(file_exists('FacultyData.php')) {

	require_once('FacultyData.php');

	extract( shortcode_atts( array(
		'title' => '',
		'intro' => '',
		'bg_color' => 'bg-white',
		'columns' => 3,
		'classes' => ['iu-content-grid', 'faculty-member-grid'],
		'extra_classes' => false,
		'uids' => '',
		'items' => '',
	), $atts ));

	// Retrieve faculty data using the list of IDs
	$faculty = [];
	$items = iusm_get_valid_items($items, 'link');

	$parsed_items = array();

	if ($uids != '') {
		foreach (explode(",", $uids) as $line) {
			$elements = explode('|', $line);
			$parsed_items[] = array('uid' => $elements[0], 'description' => $elements[1]);
		}
	}

	$items = array_merge($parsed_items, $items);
	foreach ($items as $item) {
		$uid = $item['uid'];
		$profile = new stdClass();
		try {
			$profile = new IU\FacultyData($uid);
		} catch (Exception $ex) {
			$faculty[] = ['error' => $ex->getMessage()];
			continue;
		}

		// SEO URL name
		$url_name = strtolower(str_replace(' ', '-', "{$profile->last_name}-{$profile->first_name}"));
		$url_name = preg_replace('@[^-a-z]@', '', $url_name);

		$positions = explode(';', $profile->positions);
		//$path_prefix = (stripos($_SERVER['REQUEST_URI'], '/faculty') !== false) ? 'faculty/' : '/faculty/';
		$path_prefix = '/faculty/';
		$url = "{$path_prefix}{$profile->pid}/{$url_name}";
		$fullname = $profile->first_name.(trim($profile->middle_name) != '' ? ' '.substr($profile->middle_name, 0, 1).'.' :'').' '.$profile->last_name.(count($profile->degrees) > 0 ? ", {$profile->degrees[0]}" : '');
		$faculty[] = [
			'pid' => $profile->pid,
      		'uid' => $uid,
			'fullname' => $fullname,
		  'url' => $url,
		  'position' => array_shift($positions),
		  'description' => $item['description'],
		];
	}

	$classes[] = $bg_color;
	if ($extra_classes) {
		$classes[] = $extra_classes;
	}

		return render_component('iu-content-grid:faculty_member', [
			'columns' => $columns,
			'classes' => implode(' ', $classes),
			'title' => $title,
			'intro' => $intro,
			'faculty' => $faculty,
		]);
	}

}
add_shortcode( 'iu_content_grid_faculty', 'sc_iu_content_grid_faculty' );

// Register shortcode class
if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_IU_Content_Grid_Faculty_Member extends WPBakeryShortCode {}
}

// Register Visual Composer plugin
if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('Split Component 9', ''),
		'base' => 'iu_content_grid_faculty',
		'content_element' => true,
		'icon' => 'icon-wpb-application-icon-large',
		'description' => __('Floated image, linked title, subtitle, intro text', ''),
		'category' => __('IUSM Components', ''),
		'params' => array_merge($vc_shared_params_iu_grid_defaults, [
			array(
				'type' => 'param_group',
				'value' => '',
				'heading' => __('Grid Items'),
				'param_name' => 'items',
				'description' => __('Add items to the grid'),
				'params' => [
					array(
						'type' => 'textfield',
						'heading' => __('Faculty Member University ID'),
						'param_name' => 'uid',
						'value' => '',
						'description' => __('Provide the UID of the faculty member')
					),
					array(
						'type' => 'textfield',
						'heading' => __('Description'),
						'param_name' => 'description',
						'value' => '',
						'description' => __('Provide the description text')
					),
				],
			),
			array(
				'type' => 'exploded_textarea',
				'holder' => 'div',
				'heading' => __('[OBSOLETE_FIELD_DO_NOT_USE] Faculty Member University ID', ''),
				'param_name' => 'uids',
				'value' => '',
				'description' => __('Enter Faculty Member University ID numbers (one per line)'),
			),
		]),
	));
}
