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

/** Removed because technically this code wasn't paid for */

//require_once TEMPLATEPATH . '/assets/components/events-upcoming/ajax_processing.php';
//
//if(function_exists('vc_map')) {
//
//    function sc_events_upcoming($atts)
//    {
//        extract(shortcode_atts(array(
//        ), $atts));
//
//        return render_component('events-upcoming', [
//        ]);
//    }
//
//    add_shortcode('events_upcoming', 'sc_events_upcoming');
//        /**
//         * Visual Composer Plugin definition
//         */
//        vc_map(array(
//            'base' => 'events_upcoming',
//            'name' => __('Upcoming Events', ''),
//            'icon' => THEME_PATH . '/assets/images/icons/list.png',
//            'description' => 'Displays dynamic list of events.',
//            'category' => 'IUSM Events'
//        ));
//}