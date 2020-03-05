<?php
if( function_exists('vc_map')) {
    function sc_blog_event_news_news_column($atts = array())
    {

        extract(shortcode_atts(array(
            'main_rss_events' => '',
            'campus_rss_events' => '',
            'department_rss_events' => '',
            'other_events' => '',
            'event_feed_title' => 'Events',
            'event_rss_feed_number' => '',
            'blog_rss_feed' => '',
            'blog_feed_title' => '',
            'blog_rss_feed' => '',
            'news_feed_title' => 'News',
            'news_rss_feed' => '',
            'news_rss_feed_number' => '',
            'blog_rss_feed_number' => '',
            'news_remove_image' => '',
        ), $atts));

        return render_component('event-news-blog-column', [
            'main_rss_events' => $main_rss_events,
            'campus_rss_events' => $campus_rss_events,
            'department_rss_events' => $department_rss_events,
            'other_events' => $other_events,
            'event_feed_title' => $event_feed_title,
            'event_rss_feed_number' => $event_rss_feed_number,
            'blog_rss_feed' => $blog_rss_feed,
            'blog_feed_title' => $blog_feed_title,
            'news_rss_feed' => $news_rss_feed,
            'news_feed_title' => $news_feed_title,
            'news_rss_feed_number' => $news_rss_feed_number,
            'blog_rss_feed_number' => $blog_rss_feed_number,
            'news_remove_image' => $news_remove_image,
        ]);
    }
    add_shortcode('event_news_blog_column', 'sc_blog_event_news_news_column');


    vc_map(array(
        'name' => __('Fullwidth Component 10'),
        'base' => 'event_news_blog_column',
        'description' => __('Displays Events News and Blog recent content from rss feeds.'),
        'category' => __('IUSM Components'),
        'params' => array(
          array(
              'type' => 'dropdown',
              'heading' => __("Events"),
              'param_name' => 'main_rss_events',
              'value' => array(
                __('None', '') => '',
                __('General', '') => '9',                
              ),
              'description' => __('Select an event. ', ''),
              'group' => 'Event Settings',

          ),
          array( 
            'type' => 'dropdown',
            'heading' => __( 'Campuses', '' ),
            'param_name' => 'campus_rss_events',
            'value' => array(
              __('None', '') => '',
              __('Bloomington', '') => '12',
              __('Evansville', '') => '39',
              __('Fort Wayne', '') => '33',
              __('Gary', '') => '17',
              __('Indianapolis', '') => '13',
              __('Muncie', '') => '40',
              __('South Bend', '') => '18',
              __('Terre Haute', '') => '41',
              __('West Lafayette', '') => '42',
            ),
                'description' => __( 'Select an event' ),
                'std' => '',
                'group' => 'Event Settings',

            ),

            array( 
                'type' => 'dropdown',
                'heading' => __( 'Departments', '' ),
                'param_name' => 'department_rss_events',
                'value' => array(
                  __('None', '') => '',
                  __('Anatomy and Cell Biology', '') => '55',
                  __('Anesthesia', '') => '56',
                  __('Biochemistry and Molecular Biology', '') => '57',
                  __('Biostatistics', '') => '58',
                  __('Cellular and Integrative Physiology', '') => '59',
                  __('Dermatology', '') => '61',
                  __('Emergency Medicine', '') => '62',
                  __('Family Medicine', '') => '72',
                  __('Internal Medicine', '') => '299',
                  __('Medical and Molecular Genetics', '') => '73',
                  __('Microbiology and Immunology', '') => '74',
                  __('Neurological Surgery', '') => '75',
                  __('Neurology', '') => '76',
                  __('Obstetrics and Gynecology', '') => '77',
                  __('Ophthalmology', '') => '79',
                  __('Orthopaedic Surgery', '') => '80',
                  __('Otolaryngology', '') => '81',
                  __('Pathology and Laboratory Medicine', '') => '82',
                  __('Pediatrics', '') => '42',
                  __('Pharmacology and Toxicology', '') => '83',
                  __('Physical Medicine and Rehabilitation', '') => '84',
                  __('Psychiatry', '') => '85',
                  __('Radiation Oncology', '') => '300',
                  __('Radiology and Imagain Sciences', '') => '86',
                  __('Surgery', '') => '41',
                  __('Urology', '') => '87',
                ),
                'description' => __( 'Select an event' ),
                'std' => '',
                'group' => 'Event Settings',

              ),

              array(
                'type' => 'dropdown',
                'heading' => __( 'Events', '' ),
                'param_name' => 'other_events',
                'value' => array(
                  __('None', '') => '',             
                  __('Breast Cancer', '') => '302',
                  __('Brown Center for Immunotherapy', '') => '305',
                  __('Catholic', '') => '1357',
                  __('Center for Bioethics', '') => '60',             
                  __('IMPRS', '') => '1362',
                  __('IUSMSIGs', '') => '910',
                  __('Indiana Clinical and Translational Sciences', '') => '306',
                  __('Center for Diabetes and Metabolic Diseases', '') => '304',
                  __('Melvin and Bren Simon Cancer Center', '') => '303',
                  __('MSTP', '') => '1361',
                  __('Music', '') => '1359',
                  __('Musculoskeletal Health', '') => '307',            
                  __('Residency', '') => '1369',
                  __('Stark Neurosciences Research Institute', '') => '308',           
                  __('Wells Center', '') => '309',      
                ),
                'description' => __( 'Select an event' ),
                'std' => '',
                'group' => 'Event Settings',

              ),

            array(
                'type' => 'textfield',
                'heading' => __("News Rss Feed Link"),
                'param_name' => 'news_rss_feed',
                'value' => '',
                'description' => __('Add Rss Feed url link to output most recent news post. ', ''),
                'group' => 'News Settings',

            ),
            array(
                'type' => 'textfield',
                'heading' => __("Blog Rss Feed Link"),
                'param_name' => 'blog_rss_feed',
                'value' => '',
                'description' => __('Add Rss Feed url link to output most recent blog posts. ', ''),
                'group' => 'Blog Settings',

            ),

            array(
                'type' => 'textfield',
                'heading' => __("Event Feed Title Override"),
                'param_name' => 'event_feed_title',
                'group' => 'Event Settings',
                'value' => '',
                'description' => __('Optional Title override for Event column. ', ''),
            ),


            array(
                "type" => "dropdown",
                "heading" => __("RSS Feed Length", ''),
                "param_name" => "event_rss_feed_number",
                'group' => 'Event Settings',
                "value" => postNumbers1(),
                "description" => __('Sets number of rss feeds items in loop.', ''),
                'std' => 5,
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
                "value" => postNumbers1(),
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
                "value" => postNumbers1(),
                "description" => __('Sets number of rss feeds items in loop.', ''),
                'std' => 6,
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



        ),
    ));
}


function postNumbers1(){
    $numArray = [];
    for($i = 1; $i <= 10; $i++){
        array_push($numArray, $i);
    }
    return $numArray;
}
