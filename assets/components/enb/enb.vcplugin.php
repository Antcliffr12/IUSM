<?php
/**
 * Shortcode and Visual Composer plugin definition for component
 *
 */
require_once TEMPLATEPATH . '/assets/components/enb/feed.php';
function sc_iu_enb($atts) {
    extract( shortcode_atts( array(
        'title' => '',
        'layout' => 'three_column',
        'events_rss_feeds' => '',
        'news_rss_feeds' => '',
        'blog_rss_feeds' => '',
    ), $atts ));


    $eventsRssFeeds = $events_rss_feeds === '%5B%7B%22feed_maxitems%22%3A%221%22%7D%5D' ? '' : json_decode(urldecode($events_rss_feeds));
    $eventsFeeds = !empty($eventsRssFeeds) ? aggregate_feeds($eventsRssFeeds, true) : '';

    $blogRssFeeds = $blog_rss_feeds === '%5B%7B%22feed_maxitems%22%3A%221%22%7D%5D' ? '' : json_decode(urldecode($blog_rss_feeds));
    $blogFeeds = !empty($blogRssFeeds) ? aggregate_feeds($blogRssFeeds) : '';


    $newsRssFeeds = $news_rss_feeds === '%5B%7B%22feed_maxitems%22%3A%221%22%7D%5D' ? '' : json_decode(urldecode($news_rss_feeds));
    $newsFeeds = !empty($newsRssFeeds) ? aggregate_feeds($newsRssFeeds) : '';

    return render_component('enb', [
        'title' => $title,
        'layout' => $layout,
        'events_rss_feeds' => $eventsFeeds,
        'news_rss_feeds' => $newsFeeds,
        'blog_rss_feeds' => $blogFeeds,
    ]);
}
add_shortcode('enb', 'sc_iu_enb');


if( function_exists('vc_map')) {

	/**
	 * Visual Composer Plugin definition
	 */
	vc_map(array(
		'name' => __('Events / News / Blog'),
		'base' => 'enb',
		'icon' => THEME_PATH . '/assets/images/icons/recent-news.png',
		'description' => __('Full-width #10<br>2-column #6/7'),
		'category' => __('IUSM Components'),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __('Title', ''),
				'param_name' => 'title',
				'value' => '',
				'description' => __('Enter a title here', '')
			),
			array(
				'type' => 'dropdown',
				'heading' => __('Column Layout', ''),
				'param_name' => 'layout',
				'value' => [
					'Three Column' => 'three_column',
					'Two Column' => 'two_column',
				],
				'description' => __('Changes The Layout of the Events News Blog widget', ''),
			),
			array_merge($vc_shared_params_feed_aggregator, [
				'heading' => _('Events Section'),
				'param_name' => 'events_rss_feeds',
				'group' => 'Events',
			]),
			array_merge($vc_shared_params_feed_aggregator, [
				'heading' => _('News Section'),
				'param_name' => 'news_rss_feeds',
				'group' => 'News',
				'description' => __('The output from this feed will only be the latest news article.', ''),
			]),
			array_merge($vc_shared_params_feed_aggregator, [
				'heading' => _('Blog Section'),
				'param_name' => 'blog_rss_feeds',
				'group' => 'Blog',
			]),

		)
	));

}
/**
 * Combines Multiple Feeds together.
 * @param $feedObj
 * @return array
 */
function aggregate_feeds($feedObj, $_isEvents = false){

    $aggregate = [];
    try {
        if(!empty($feedObj)) {
            foreach ($feedObj as $content) {
                $feed = new IUSM_Feed();
                $feed->set_number($content->feed_maxitems);
                $feedItems = $feed->get_feed($content->feed_url, $_isEvents);

                if(!empty($feedItems)) {

                    foreach ($feedItems as $item) {
                        array_push($aggregate, [
                            'title' => isset($item['title']) ? $item['title'] : '',
                            'date' => isset($item['date']) ? $item['date'] : '',
                            'link' => isset($item['link']) ? $item['link'] : '',
                            'description' => isset($item['description']) ? $item['description'] : '',
                            'imageSrc' => isset($item['imageSrc']) ? $item['imageSrc'] : '',
                        ]);
                    }
                }
            }
        }

        usort($aggregate, function($a, $b) {
            return $b['date']- $a['date'];
        });
    } catch (Exception $ex) {
        array_push($aggregate, [
            'title' => 'Error retrieving feed: ' . $ex->getMessage(),
            'date' => time(),
            'link' => '',
            'description' => '',
            'imageSrc' => '',
        ]);
    }

    return $aggregate;
}



