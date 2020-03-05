<?php

function full_width_video($atts) {
    extract( shortcode_atts( array(
        'title' => '',
        'title_element' => 'h2',
        'link' => 'https://vimeo.com/51589652',
        'el_width' => '60',
        'bg_color' => 'bg-iu-cream',
        'el_aspect' => '169',
        'align' => '',
        'video_image' => '',
        'el_class' => '',
	    'expand' => '',
    ), $atts ));


    return render_component('fullwidth-video', [
        'title' => $title,
        'title_element' => $title_element,
        'link' => $link,
        'el_width' => $el_width,
        'bg_color' => $bg_color,
        'el_aspect' => $el_aspect,
        'align' => $align,
        'video_image' => $video_image,
        'el_class' => $el_class,
	    'expand' => $expand,
    ]);
}
add_shortcode('fullwidth_video', 'full_width_video');

/**
 * Visual Composer Plugin definition
 */
if( function_exists('vc_map')) {
	vc_map(array(
		"name" => __("Split Component 17", ""),
		"base" => "fullwidth_video",
		'icon' => 'icon-wpb-film-youtube',
		'description' => __('Displays a full width video', ''),
		"category" => __('IUSM Components', ''),
		"params" => array(
			array(
				'type' => 'textfield',
				'heading' => __('Widget title', 'js_composer'),
				'param_name' => 'title',
				'description' => __('Enter text used as widget title (Note: located above content element).', 'js_composer'),
			),
			array(
				'type' => 'dropdown',
				'heading' => __('Widget title element', 'js_composer'),
				'param_name' => 'title_element',
				'description' => __('Heading element for widget title.', 'js_composer'),
				'value' => array(
					__('Select Element') => '',
					__('H1', '') => 'h1',
					__('H2', '') => 'h2',
					__('H3', '') => 'h3',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __('Video link', 'js_composer'),
				'param_name' => 'link',
				'value' => 'https://vimeo.com/51589652',
				'admin_label' => true,
				'description' => sprintf(__('Enter link to video (Note: read more about available formats at WordPress <a href="%s" target="_blank">codex page</a>).', 'js_composer'), 'http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F'),
			),
			array(
				'type' => 'dropdown',
				'heading' => __('Video width', 'js_composer'),
				'param_name' => 'el_width',
				'value' => array(
					'100%' => '100',
					'90%' => '90',
					'80%' => '80',
					'70%' => '70',
					'60%' => '60',
					'50%' => '50',
					'40%' => '40',
					'30%' => '30',
					'20%' => '20',
					'10%' => '10',
				),
				'description' => __('Select video width (percentage).', 'js_composer'),
			),
			array_merge($vc_shared_params_iu_bg_colors, [
				"description" => __("Choose background color.", ""),
				'std' => 'bg-iu-cream',
			]),
			array(
				'type' => 'dropdown',
				'heading' => __('Video aspect ratio', 'js_composer'),
				'param_name' => 'el_aspect',
				'value' => array(
					'16:9' => '169',
					'4:3' => '43',
				),
				'description' => __('Select video aspect ratio.', 'js_composer'),
			),
      array(
        'type' => 'attach_image',
        'value' => '',
        'heading' => 'background Image',
        'param_name' => 'video_image',
        'admin_label' => true,
        'description' => __('Select image from media library.'),

      ),
			array(
				'type' => 'dropdown',
				'heading' => __('Alignment', 'js_composer'),
				'param_name' => 'align',
				'description' => __('Select video alignment.', 'js_composer'),
				'value' => array(
					__('Center', 'js_composer') => 'center',
					__('Left', 'js_composer') => 'left',
					__('Right', 'js_composer') => 'right',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __('Extra class name', 'js_composer'),
				'param_name' => 'el_class',
				'description' => __('Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer'),
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Allow Full Expansion of Video Area.'),
				'description' => __('Remove\'s wrapper that allows video touch edges of the browser window.'),
				'param_name' => 'expand',
			),
		)
	));
}
