<?php
/**
 * Image with title and intro paragraph
 */

// Register shortcode
function sc_iu_content_grid_c( $atts, $content = '' ) {

	extract( shortcode_atts( array(
		'title' => '',
		'intro' => '',
		'bg_color' => 'bg-white',
		'columns' => 3,
		'classes' => ['iu-content-grid', 'grid-variant-c'],
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
		'variant' => 'C',
		'content' => do_shortcode($content),
	]);

}
add_shortcode( 'iu_content_grid_c', 'sc_iu_content_grid_c' );

// Register shortcode class
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_IU_Content_Grid_C extends WPBakeryShortCodesContainer {}
}

// Register Visual Composer plugin
if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('Fullwidth Component 15', ''),
		'base' => 'iu_content_grid_c',
		'as_parent' => array('only' => 'iu_content_grid_item_c'),
		'content_element' => true,
		'icon' => 'icon-wpb-application-icon-large',
		'description' => __('Image with title and intro paragraph', ''),
		'category' => __('IUSM Layout Components', ''),
		'js_view' => 'VcColumnView',
		'params' => array_merge($vc_shared_params_iu_grid_defaults, []),
	));
}
