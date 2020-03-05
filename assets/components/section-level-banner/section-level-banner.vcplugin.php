<?php
if( function_exists('vc_map')) {
function sc_section_level_banner($atts = array())
{

	extract(shortcode_atts(array(
		'title' => $title,
		'bg_color' => 'bg-iu-crimson',
		'font_color' => 'color-white',
		'image' => '',
	), $atts));

	return render_component('section-level-banner', [
		'title' => $title,
		'bg_color' => $bg_color,
		'font_color' => $font_color,
		'image' => $image,
	]);
}
add_shortcode('section_level_banner', 'sc_section_level_banner');


	vc_map(array(
		'name' => __('Section Level Banner'),
		'base' => 'section_level_banner',
		'icon' => THEME_PATH . '/assets/images/icons/sections.png',
		'description' => __('Title Banner with solid color or background image.'),
		'category' => __('IUSM Components'),
		'params' => array(
			array(
				"type" => "textfield",
				"heading" => __("Title"),
				"param_name" => "title",
				"value" => '',
				'std' => 'Banner Title',
				"description" => __("Title text to display above widget")
			),

			array_merge($vc_shared_params_iu_font_colors, [
				'description' => __('Select the font color for the section'),
			]),

			array_merge($vc_shared_params_iu_bg_colors, [
				'description' => __('Select the background color for the section (extends to full width of viewport)'),
			]),

			array(
				'type' => 'attach_image',
				'value' => '',
				'description' => __('Will Override background color if selected.'),
				'heading' => 'Image',
				'param_name' => 'image',
				'admin_label' => true,
			),

		),
	));
}