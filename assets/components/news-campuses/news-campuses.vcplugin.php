<?php

if( function_exists('vc_map')) {

	function sc_iu_news_campuses($atts = array())
	{

		extract(shortcode_atts(array(
			'title' => 'News Campuses',
			'intro' => '<p>Each IU School of Medicine campus offers a high-quality medical education with an integrated curriculum, access to leading medical research and clinical resources, and a rich campus life.</p>',
		), $atts));

		return render_component('news-campuses', [
			'title' => $title,
			'intro' => $intro,
		]);
	}

	add_shortcode('iu_news_campuses', 'sc_iu_news_campuses');

	vc_map(array(
		'name' => __('News Campuses'),
		'base' => 'iu_news_campuses',
		'icon' => THEME_PATH . '/assets/components/news-campuses/vc-icon.png',
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
