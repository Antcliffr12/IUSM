<?php
if( function_exists('vc_map')) {
	function sc_news_featured_rss($atts = array())
	{

		extract(shortcode_atts(array(
      'title' => '',
			'news_rss_feed_number' => '',
			'bg_color' => 'bg-white',
			  'margin_adjust' => '',
		), $atts));

		return render_component('news-topic', [
        'title' => $title,
				'news_rss_feed_number' => $news_rss_feed_number,
				'bg_color' => $bg_color,
				'margin_adjust' => $margin_adjust,

		]);
	}
	add_shortcode('news_featured_rss', 'sc_news_featured_rss');


	vc_map(array(
		'name' => __('Featured News Rss'),
		'base' => 'news_featured_rss',
		'icon' => THEME_PATH . '/assets/images/icons/featured-post.png',
		'description' => __('Sets News featured post based on Feed.'),
		'category' => __('IUSM Components'),
    'params' => array(
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
				'group' => 'News Settings',
			),
			array(
					'type' => 'dropdown',
					'heading' => __('Adjust for margin for breadcrumbs.'),
					'param_name' => 'margin_adjust',
					'value' => array(
							'false',
							'true',
					),
					'description' => __('Allows user to account extra margin on pages with breadcrumbs.'),
					'std' => 'false',
					'group' => 'News Settings',

			),
        array(
            "type" => "textfield",
            "heading" => __("Title"),
            "param_name" => "title",
            "value" => '',
						'group' => 'News Settings',
            'std' => '',
            "description" => __("Title text to display above widget")
        ),
				array(
						"type" => "dropdown",
						"heading" => __("RSS Feed Length", ''),
						"param_name" => "news_rss_feed_number",
						'group' => 'News Settings',
						"value" => PostNesTitles(),
						"description" => __('Sets number of News feeds items in loop.', ''),
						'std' => 1,
				),

			)
	  	));
}


function PostNesTitles(){
    $numArray = [];
    for($i = 1; $i <= 3; $i++){
        array_push($numArray, $i);
    }
    return $numArray;
}
