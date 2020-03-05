<?php

if( function_exists('vc_map')) {

	function sc_iu_campuses($atts = array())
	{

		extract(shortcode_atts(array(
			'title' => 'Campuses',
			'intro' => '<p>Each IU School of Medicine campus offers a high-quality medical education with an integrated curriculum, access to leading medical research and clinical resources, and a rich campus life.</p>',
		), $atts));

		return render_component('campuses', [
			'title' => $title,
			'intro' => $intro,
		]);
	}

	add_shortcode('iu_campuses', 'sc_iu_campuses');

	vc_map(array(
		'name' => __('Campuses'),
		'base' => 'iu_campuses',
		'icon' => THEME_PATH . '/assets/components/campuses/vc-icon.png',
		'description' => __('Summary campus info and an interactive map.'),
		'category' => __('IUSM Components'),
		'params' => array(
			array(
				"type" => "textfield",
				"heading" => __("Title"),
				"param_name" => "title",
				"value" => '',
				'std' => 'Campuses',
				"description" => __("Title text to display above widget")
			),
			array(
				"type" => "textarea",
				"heading" => __("Text"),
				"param_name" => "intro",
				"value" => "",
				"description" => __("Intro paragraph")
			),
		),
	));
}