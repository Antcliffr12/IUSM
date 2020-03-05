<?php
/**
 * Shortcode and Visual Composer plugin definition for component
 *
 */

/**
 * Shortcode processor for {mycomponent}
 * @param $atts Shortcode attribute array
 * @return string The rendered output of the shortcode
 */
function sc_component_mycomponent($atts) {
    return render_component('mycomponent', $atts);
}
add_shortcode('component_mycomponent', 'sc_component_mycomponent');

/**
 * Visual Composer Plugin definition
 */
vc_map( array(
    "name" => __( "My Component", "" ),
    "base" => "component_mycomponent",
    'icon' => THEME_PATH.'/assets/components/mycomponent/vc-icon.png',
    'description' => __( 'Displays mycomponent', '' ),
    "category" => __( 'Content', '' ),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __( "Title", "" ),
            "param_name" => "title",
            "value" => "",
            "description" => __( "Enter a title here", "" )
        ),
    )
));
