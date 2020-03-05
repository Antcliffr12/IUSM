<?php
if( function_exists('vc_map')) {
    function sc_campus_news($atts = array())
    {

        extract(shortcode_atts(array(
          'campus_news_rss_feed' => '',
        ), $atts));

        return render_component('campus-news', [
            'campus_news_rss_feed' => $campus_news_rss_feed,
        ]);
    }
    add_shortcode('campus_news', 'sc_campus_news');


    vc_map(array(
        'name' => __('Campus News'),
        'base' => 'campus_news',
        'icon' => THEME_PATH . '/assets/components/publications/vc-icon.png',
        'description' => __('Displays News content from rss feeds.'),
        'category' => __('IUSM Components'),
        'params' => array(



            array(
                'type' => 'dropdown',
                'heading' => __("Select Campus"),
                'param_name' => 'campus_news_rss_feed',
                'value' => [
                  'Please Select Campus' => '',
                  'Indianapolis' => 'indianapolis',
                  'Bloomington' => 'bloomington',
                  'Evansville' => 'evansville',
                  'Fort Wayne' => 'fort-wayne',
                  'Muncie' => 'muncie',
                  'Gary' => 'gary',
                  'South Bend' => 'south-bend',
                  'Terre Haute' => 'terre-haute',
                  'West Lafayette' => 'west-lafayette',

                  ],
                'description' => __('Add Rss Feed url link to output most recent News based on campus post. ', ''),
            ),

        ),
    ));
}
