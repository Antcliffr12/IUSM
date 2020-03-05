<?php
if( function_exists('vc_map')) {
    function sc_blog_news_split_column($atts = array())
    {

        extract(shortcode_atts(array(
            'blog_feed_title' => '',
            'blog_rss_feed' => '',
            'news_feed_title' => '',
            'news_rss_feed' => '',
            'news_rss_feed_number' => '',
            'blog_rss_feed_number' => '',
            'news_remove_image' => '',
        ), $atts));

        return render_component('blog-news-split-column', [
            'blog_rss_feed' => $blog_rss_feed,
            'blog_feed_title' => $blog_feed_title,
            'news_rss_feed' => $news_rss_feed,
            'news_feed_title' => $news_feed_title,
            'news_rss_feed_number' => $news_rss_feed_number,
            'blog_rss_feed_number' => $blog_rss_feed_number,
            'news_remove_image' => $news_remove_image,
        ]);
    }
    add_shortcode('blog_news_split_column', 'sc_blog_news_split_column');


    vc_map(array(
        'name' => __('Split Component 6'),
        'base' => 'blog_news_split_column',
        'icon' => THEME_PATH . '/assets/components/blog-news-split-column/vc-icon.png',
        'description' => __('Displays News and Blog recent content from rss feeds.'),
        'category' => __('IUSM Components'),
        'params' => array(



            array(
                'type' => 'textfield',
                'heading' => __("News Rss Feed Link"),
                'param_name' => 'news_rss_feed',
                'value' => '',
                'description' => __('Add Rss Feed url link to output most recent news post. ', ''),
            ),
            array(
                'type' => 'textfield',
                'heading' => __("Blog Rss Feed Link"),
                'param_name' => 'blog_rss_feed',
                'value' => '',
                'description' => __('Add Rss Feed url link to output most recent blog posts. ', ''),
            ),




            array(
                'type' => 'textfield',
                'heading' => __("News Feed Title Override"),
                'param_name' => 'news_feed_title',
                'group' => 'News Settings',
                'value' => '',
                'description' => __('Optional Title override for News column. ', ''),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("RSS Feed Length", ''),
                "param_name" => "news_rss_feed_number",
                'group' => 'News Settings',
                "value" => postNumbers(),
                "description" => __('Sets number of rss feeds items in loop.', ''),
                'std' => 1,
            ),
            array(
                'type' => 'checkbox',
                'heading' => __('Remove Images From Output.'),
                'group' => 'News Settings',
                'description' => __('Remove\'s images and default images from output.'),
                'param_name' => 'news_remove_image',
            ),



            array(
                'type' => 'textfield',
                'heading' => __("Blog Feed Title Override"),
                'param_name' => 'blog_feed_title',
                'group' => 'Blog Settings',
                'value' => '',
                'description' => __('Optional Title override for Blog column. ', ''),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("RSS Feed Length", ''),
                "param_name" => "blog_rss_feed_number",
                'group' => 'Blog Settings',
                "value" => postNumbers(),
                "description" => __('Sets number of rss feeds items in loop.', ''),
                'std' => 6,
            ),



        ),
    ));
}


function postNumbers(){
    $numArray = [];
    for($i = 1; $i <= 10; $i++){
        array_push($numArray, $i);
    }
    return $numArray;
}
