<?php
if( function_exists('vc_map')) {
	function sc_news_featured_post($atts = array())
	{

		extract(shortcode_atts(array(
			'bg_color' => 'bg-white',
            'category_id' => '',
            'margin_adjust' => '',
		), $atts));

		return render_component('news-featured-post', [
			'bg_color' => $bg_color,
            'category_id' => $category_id,
            'margin_adjust' => $margin_adjust,
		]);
	}
	add_shortcode('news_featured_post', 'sc_news_featured_post');


	vc_map(array(
		'name' => __('News Featured Post'),
		'base' => 'news_featured_post',
		'icon' => THEME_PATH . '/assets/images/icons/featured-post.png',
		'description' => __('Sets blog featured post based on category.'),
		'category' => __('IUSM Components'),
		'params' => array(
			array_merge($vc_shared_params_iu_bg_colors, [
				'description' => __('Select the background color for the section (extends to full width of viewport)'),
			]),
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
            ),
		),
	));
}
