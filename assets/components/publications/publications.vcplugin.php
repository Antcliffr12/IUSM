<?php
if( function_exists('vc_map')) {
    function sc_publications_column($atts = array())
    {

        extract(shortcode_atts(array(
            'blog_feed_title' => 'Blog',
            'blog_rss_feed' => '',
            'news_feed_title' => 'News',
            'news_rss_feed' => '',
            'news_rss_feed_number' => '',
            'blog_rss_feed_number' => '',
            'news_remove_image' => '',
        ), $atts));

        return render_component('publications', [
            'blog_rss_feed' => $blog_rss_feed,
            'blog_feed_title' => $blog_feed_title,
            'news_rss_feed' => $news_rss_feed,
            'news_feed_title' => $news_feed_title,
            'news_rss_feed_number' => $news_rss_feed_number,
            'blog_rss_feed_number' => $blog_rss_feed_number,
            'news_remove_image' => $news_remove_image,
            'news_remove_content' => $news_remove_content,
        ]);
    }
    add_shortcode('publications_column', 'sc_publications_column');


    vc_map(array(
        'name' => __('Publications Column'),
        'base' => 'publications_column',
        'icon' => THEME_PATH . '/assets/components/publications/vc-icon.png',
        'description' => __('Displays Publications content from rss feeds.'),
        'category' => __('IUSM Components'),
        'params' => array(



            array(
                'type' => 'textfield',
                'heading' => __("Publications Rss Feed Link"),
                'param_name' => 'news_rss_feed',
                'group' => 'Publications Settings',
                'value' => '',
                'description' => __('Add Rss Feed url link to output most recent Publications post. ', ''),
            ),


            array(
                'type' => 'textfield',
                'heading' => __("Feed Title"),
                'param_name' => 'news_feed_title',
                'group' => 'Publications Settings',
                'value' => '',
                'description' => __('Optional Title override for Publications column. ', ''),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("RSS Feed Length", ''),
                "param_name" => "news_rss_feed_number",
                'group' => 'Publications Settings',
                "value" => pubNumbers(),
                "description" => __('Sets number of rss feeds items in loop.', ''),
                'std' => 1,
            ),
            array(
                'type' => 'checkbox',
                'heading' => __('Remove Images From Output.'),
                'group' => 'Publications Settings',
                'description' => __('Remove\'s images and default images from output.'),
                'param_name' => 'news_remove_image',
            ),




        ),
    ));
}


function pubNumbers(){
    $numArray = [];
    for($i = 1; $i <= 10; $i++){
        array_push($numArray, $i);
    }
    return $numArray;
}
