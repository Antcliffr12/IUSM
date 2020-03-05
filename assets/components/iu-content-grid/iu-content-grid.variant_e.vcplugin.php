<?php
/**
 * Floated image, linked title, subtitle, intro text
 */

// Register shortcode
function sc_iu_content_grid_e( $atts, $content = '' ) {

	extract( shortcode_atts( array(
		'title' => '',
		'intro' => '',
		'bg_color' => 'bg-white',
		'columns' => 3,
		'classes' => ['iu-content-grid', 'grid-variant-e'],
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
		'variant' => 'E',
		'content' => do_shortcode($content),
	]);

}
add_shortcode( 'iu_content_grid_e', 'sc_iu_content_grid_e' );

// Register shortcode class
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_IU_Content_Grid_E extends WPBakeryShortCodesContainer {}
}

// Register Visual Composer plugin
if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('Grid Type E', ''),
		'base' => 'iu_content_grid_e',
		'as_parent' => array('only' => 'iu_content_grid_item_e'),
		'content_element' => true,
		'icon' => 'icon-wpb-application-icon-large',
		'description' => __('Floated image, linked title, subtitle, intro text', ''),
		'category' => __('IUSM Layout Components', ''),
		'js_view' => 'VcColumnView',
		'params' => array_merge($vc_shared_params_iu_grid_defaults, []),
	));
}
