<?php
/**
 * Shortcode and Visual Composer plugin definition for component
 *
 */

function stat_bar($atts) {
    extract( shortcode_atts( array(
        'title' => '',
        'bg_color' => 'bg-iu-crimson',
        'animation_toggle' => '',
        'column_one_number' => '',
        'column_one_description' => '',
        'column_two_number' => '',
        'column_two_description' => '',
        'column_three_number' => '',
        'column_three_description' => '',
        'column_four_number' => '',
        'column_four_description' => '',

    ), $atts ));

    return render_component('stat-bar', [
        'title' => $title,
        'bg_color' => $bg_color,
        'animation_toggle' => $animation_toggle,
        'column_one_number' => $column_one_number,
        'column_one_description' => $column_one_description,
        'column_two_number' => $column_two_number,
        'column_two_description' => $column_two_description,
        'column_three_number' => $column_three_number,
        'column_three_description' => $column_three_description,
        'column_four_number' => $column_four_number,
        'column_four_description' => $column_four_description,
    ]);
}
add_shortcode('stat-bar', 'stat_bar');


/**
 * Visual Composer Plugin definition
 */
if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('Split Component 13'),
		'base' => 'stat-bar',
		'icon' => THEME_PATH . '/assets/images/icons/counter.png',
		'description' => __('Fullwidth #13'),
		'category' => __('IUSM Components'),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __('Title'),
				'param_name' => 'title',
				'value' => '',
				'description' => __('Enter a title here')
			),
			array_merge($vc_shared_params_iu_bg_colors, [
				'description' => __('Choose background color.'),
				'std' => 'bg-iu-crimson',
			]),
			array(
				'type' => 'checkbox',
				'heading' => __('Number Animation', ''),
				'param_name' => 'animation_toggle',
				'value' => [
					'Animate' => 'true',
				],
				'description' => __('Check to animate given numbers to count up from 0.', '')
			),


			array(
				'type' => 'textfield',
				'heading' => __('Column #1: Number'),
				'param_name' => 'column_one_number',
				'value' => '',
				'group' => 'Column One',
			),
			array(
				'type' => 'textarea',
				'heading' => __('Column #1: Description'),
				'param_name' => 'column_one_description',
				'value' => '',
				'group' => 'Column One',
			),


			array(
				'type' => 'textfield',
				'heading' => __('Column #2: Number'),
				'param_name' => 'column_two_number',
				'value' => '',
				'group' => 'Column Two',
			),
			array(
				'type' => 'textarea',
				'heading' => __('Column #2: Description'),
				'param_name' => 'column_two_description',
				'value' => '',
				'group' => 'Column Two',
			),


			array(
				'type' => 'textfield',
				'heading' => __('Column #3: Number'),
				'param_name' => 'column_three_number',
				'value' => '',
				'group' => 'Column Three',
			),
			array(
				'type' => 'textarea',
				'heading' => __('Column #3: Description'),
				'param_name' => 'column_three_description',
				'value' => '',
				'group' => 'Column Three',
			),


			array(
				'type' => 'textfield',
				'heading' => __('Column #4: Number'),
				'param_name' => 'column_four_number',
				'value' => '',
				'group' => 'Column Four',
			),
			array(
				'type' => 'textarea',
				'heading' => __('Column #4: Description'),
				'param_name' => 'column_four_description',
				'value' => '',
				'group' => 'Column Four',
			),
		)
	));
}


function stat_check_number($number){

    if($number === '---'){
        return $number;
    }else{
        $newNumber = trim(strtolower($number));
        $checkNumber = ctype_digit($newNumber);
        if($checkNumber){
            return $newNumber;
        }else{
            return '---';
        }
    }
}
