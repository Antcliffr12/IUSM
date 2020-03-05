<?php

function sc_iu_section_block_color( $atts, $content = '' ) {
	extract( shortcode_atts( array(
		'full_width' => false,
		'background_width' => false,
		'vertical_padding_mode' => 'no-padding',
		'vertical_margin_mode' => '',
		'bg_color' => 'bg-white',
		'extra_classes' => false,
		'inject_row' => false,
		'classes' => ['iu-section-block'],
	), $atts ) );

	if ($bg_color != '') {
		$classes[] = "has-color $bg_color";
	}
	$classes[] = $vertical_padding_mode;

	if ($vertical_margin_mode != '') {
		$classes[] = $vertical_margin_mode;
	}

	$classes[] = $background_width;
	if($background_width != false){
		$classes[] = 'background-container';
	}



	$container_mode = $full_width ? 'l-fullwidth' : 'container';
	if ($extra_classes) {
		$classes[] = $extra_classes;
	}

	$background_mode = $background_width ? 'background-container' : '';

	$processed_content = do_shortcode($content);

	if ($inject_row) {
		$processed_content = '<div class="row">' . $processed_content . '</div>';
	}

	return render_component('iu-section-block-color', [
		'classes' => implode(' ', $classes),
		'container_mode' => $container_mode,
	    'processed_content' => $processed_content,
	]);
}
add_shortcode( 'iu_section_block_color', 'sc_iu_section_block_color' );

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_IU_Section_Block_Color extends WPBakeryShortCodesContainer {}
}
if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('Section Block Color'),
		'base' => 'iu_section_block_color',
		'is_container' => true,
		'content_element' => true,
		'icon' => THEME_PATH . '/assets/components/iu-section-block/vc-icon.png',
		'category' => __('IUSM Layout Components'),
		'description' => __('Represents a section of the page that holds content and components'),
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => __('Content Mode'),
				'param_name' => 'full_width',
				'value' => array(
					__('Normal') => false,
					__('Full-width') => true,
				),
				'description' => __('Normal section content is centered within the viewport and constrained to a maximum width. Full-width section content extends to fill the available space.'),
				'std' => false,
			),
			array_merge($vc_shared_params_iu_bg_colors, [
				'description' => __('Select the background color for the section (extends to full width of viewport)'),
			]),

			array(
				'type' => 'dropdown',
				'heading' => __('Vertical Padding Mode'),
				'param_name' => 'vertical_padding_mode',
				'value' => array(
					__('None') => 'no-padding',
					__('Standard') => 'padding-normal',
					__('Condensed') => 'padding-condensed',
					__('Top Only') => 'padding-normal no-padding-bottom',
					__('Top Only (Condensed)') => 'padding-condensed no-padding-bottom',
					__('Bottom Only') => 'padding-normal no-padding-top',
					__('Bottom Only (Condensed)') => 'padding-condensed no-padding-top',
					__('Top Condensed, Bottom Standard') => 'padding-normal padding-condensed-top',
					__('Top Standard, Bottom Condensed') => 'padding-normal padding-condensed-bottom',
				),
				'description' => __('Select whether section will have vertical padding applied'),
				'std' => 'no-padding',
			),
			array(
				'type' => 'dropdown',
				'heading' => __('Vertical Margin Mode'),
				'param_name' => 'vertical_margin_mode',
				'value' => array(
					__('None') => '',
					__('Standard') => 'margin-normal-top margin-normal-bottom',
					__('Condensed') => 'margin-condensed-top margin-condensed-bottom',
					__('Top Only') => 'margin-normal-top',
					__('Top Only (Condensed)') => 'margin-condensed-top',
					__('Bottom Only') => 'margin-normal-bottom',
					__('Bottom Only (Condensed)') => 'margin-condensed-bottom',
					__('Top Condensed, Bottom Standard') => 'margin-condensed-top margin-normal-bottom',
					__('Top Standard, Bottom Condensed') => 'margin-normal-top margin-condensed-bottom',
				),
				'description' => __('This should usually be left at "None", but in some cases it can be useful to set a margin. For example, if you have two color-banded sections butting up against one another and need whitespace between them.'),
				'std' => '',
			),
			array(
				'type' => 'dropdown',
				'heading' => __('Bootstrap Row?'),
				'param_name' => 'inject_row',
				'value' => array(
					__('No') => false,
					__('Yes') => true,
				),
				'description' => __('If yes, an extra row element is created to contain interior columns'),
				'std' => false,
			),
			array(
				'type' => 'textfield',
				'heading' => __('Extra CSS Classes'),
				'param_name' => 'extra_classes',
				'description' => __('(Optional) A space-separated list of additional CSS classnames that will be applied to the element.'),
			),

		),
		'js_view' => 'VcColumnView',
	));
}
