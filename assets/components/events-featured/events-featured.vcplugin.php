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

//if(function_exists('vc_map')) {
//
//    function sc_events_featured($atts)
//    {
//        extract(shortcode_atts(array(
//            'image' => '',
//        ), $atts));
//
//        return render_component('events-featured', [
//            'image' => $image,
//        ]);
//    }
//
//    add_shortcode('events_featured', 'sc_events_featured');
//
//        /**
//         * Visual Composer Plugin definition
//         */
//        vc_map(array(
//            'base' => 'events_featured',
//            'name' => __('Featured Event', ''),
//            'icon' => THEME_PATH . '/assets/images/icons/list.png',
//            'description' => 'Displays dynamic list of events.',
//            'category' => 'IUSM Events'
//        ));
//
//}