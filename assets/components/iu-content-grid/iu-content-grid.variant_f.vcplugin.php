<?php
/**
 * Floated landscape image, linked title, intro text
 */

// Register shortcode
function sc_iu_content_grid_f( $atts, $content = '' ) {

	extract( shortcode_atts( array(
		'title' => '',
		'intro' => '',
		'bg_color' => 'bg-white',
		'columns' => 3,
		'classes' => ['iu-content-grid', 'grid-variant-f'],
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
		'variant' => 'F',
		'content' => do_shortcode($content),
	]);

}
add_shortcode( 'iu_content_grid_f', 'sc_iu_content_grid_f' );

// Register shortcode class
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_IU_Content_Grid_F extends WPBakeryShortCodesContainer {}
}

// Register Visual Composer plugin
if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('Fullwidth Component 19', ''),
		'base' => 'iu_content_grid_f',
		'as_parent' => array('only' => 'iu_content_grid_item_f'),
		'content_element' => true,
		'icon' => 'icon-wpb-application-icon-large',
		'description' => __('Floated landscape image, linked title, intro text', ''),
		'category' => __('IUSM Layout Components', ''),
		'js_view' => 'VcColumnView',
		'params' => array_merge($vc_shared_params_iu_grid_defaults, []),
	));
}
