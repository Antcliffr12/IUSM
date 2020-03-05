<?php
/**
 * Testimonials
 */

// Register shortcode
function sc_iu_testimonials( $atts, $content = '' ) {

	extract( shortcode_atts( array(
		'title' => '',
		'intro' => '',
		'bg_color' => 'bg-white',
		'columns' => 2,

	), $atts ));


	return render_component('iu-testimonials', [
		'columns' => $columns,
		'title' => $title,
		'intro' => $intro,
		'bg_color' => $bg_color,
		'content' => do_shortcode($content),
	]);

}
add_shortcode( 'iu_testimonials', 'sc_iu_testimonials' );

// Register shortcode class
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_iu_testimonials extends WPBakeryShortCodesContainer {}
}

// Register Visual Composer plugin
if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('IU Testimonials', ''),
		'base' => 'iu_testimonials',
		'as_parent' => array('only' => 'iu_testimonials_item'),
		'content_element' => true,
		'icon' => 'icon-wpb-application-icon-large',
		'description' => __('Testimonials Half and Full Width', ''),
		'category' => __('IUSM Layout Components', ''),
		'js_view' => 'VcColumnView',
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Grid Layout', '' ),
				'param_name' => 'columns',
				'value' => array(
					__('1 Column') => 1,
					__('2 Columns') => 2,
				),
				'description' => __( 'Select the number of columns this grid will use at the largest screen size.' ),
				'std' => 2,
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Background Color', '' ),
				'param_name' => 'bg_color',
				'value' => array(
					__('None', '') => '',
					__('White', '') => 'bg-white',
					__('IU Dark Crimson', '') => 'bg-iu-dark-crimson',
					__('IU Crimson', '') => 'bg-iu-crimson',
					__('IU Cream', '') => 'bg-iu-cream',
					__('IU Dark Gold', '') => 'bg-iu-dark-gold',
					__('IU Gold', '') => 'bg-iu-gold',
					__('IU Dark Mint', '') => 'bg-iu-dark-mint',
					__('IU Mint', '') => 'bg-iu-mint',
					__('IU Dark Midnight', '') => 'bg-iu-dark-midnight',
					__('IU Midnight', '') => 'bg-iu-midnight',
					__('IU Dark Majestic', '') => 'bg-iu-dark-majestic',
					__('IU Majestic', '') => 'bg-iu-majestic',
					__('IU Dark Limestone', '') => 'bg-iu-dark-limestone',
					__('IU Limestone', '') => 'bg-iu-limestone',
					__('IU Black', '') => 'bg-iu-black',
					__('IU Mahogany', '') => 'bg-iu-mahogany',
				),
				'description' => __( 'Select an optional background color for the element' ),
				'std' => '',
			),
		),
	));
}
