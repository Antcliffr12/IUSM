<?php
/**
 * Shortcode and Visual Composer plugin definition for component
 *
 */

function sc_iu_events_bar($atts) {

    extract( shortcode_atts( array(
        'title' => 'Events Bar',
        'events_category' => '',
    ), $atts ));

    $eventsCategory = (strtolower($events_category) !== 'select' ) ? get_cat_ID($events_category) : 'posts';
    $args = [
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 3,
        'cat' => $eventsCategory,
    ];

    $events = new WP_Query($args);

    return render_component('iu-events-bar', [
        'title' => $title,
        'events' => $events,
    ]);

}
add_shortcode('iu_events_bar', 'sc_iu_events_bar');

/**
 * Visual Composer Plugin definition
 */
if( function_exists('vc_map')) {
	if(function_exists('vc_shared_params_categories')) {
		vc_map(array(
			'name' => __('Events Bar'),
			'base' => 'iu_events_bar',
			'icon' => 'fa fa-2x fa-calendar',
			'description' => __('2-Column #7'),
			'category' => __('IUSM Components'),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __('Title'),
					'param_name' => 'title',
					'value' => '',
					'description' => __('Enter a title here')
				),
				array_merge(vc_shared_params_categories(), [
					'description' => __('Select a Category from which events will be pulled.'),
					'heading' => _('Events Category'),
					'param_name' => 'events_category',
				]),
			)
		));
	}
}




