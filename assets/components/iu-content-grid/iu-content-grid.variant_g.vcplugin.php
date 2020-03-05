<?php
/**
 * Floated image, linked title, subtitle, intro text
 */

// Register shortcode
function sc_iu_content_grid_g( $atts, $content = '' ) {

    extract( shortcode_atts( array(
        'title' => '',
        'intro' => '',
        'bg_color' => 'bg-white',
        'columns' => 3,
        'classes' => ['iu-content-grid', 'grid-variant-g'],
        'extra_classes' => false,
    ), $atts ));

    $classes[] = $bg_color;
    if ($extra_classes) {
        $classes[] = $extra_classes;
    }

    return render_component('iu-content-grid', [
        'columns' => $columns,
        'classes' => implode(' ', $classes),
        'title' => $title,
        'intro' => $intro,
        'variant' => 'G',
        'content' => do_shortcode($content),
    ]);

}
add_shortcode( 'iu_content_grid_g', 'sc_iu_content_grid_g' );

// Register shortcode class
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_IU_Content_Grid_G extends WPBakeryShortCodesContainer {}
}

// Register Visual Composer plugin
if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('Split Component 11', ''),
		'base' => 'iu_content_grid_g',
		'as_parent' => array('only' => 'iu_content_grid_item_g'),
		'content_element' => true,
		'icon' => 'icon-wpb-application-icon-large',
		'description' => __('Grid variant that displays similar to Variant E, but outputs a single faculty member.', ''),
		'category' => __('IUSM Layout Components', ''),
		'js_view' => 'VcColumnView',
		'params' => array_merge($vc_shared_params_iu_grid_defaults, []),
	));
}
