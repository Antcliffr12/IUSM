<?php 

if(function_exists('vc_map')){
    function sc_LWeventsBlogsNews($atts = array())
    {
        extract(shortcode_atts(array(
            'main_rss_feed' => '',
            'campus_rss_feed' => '',
            'department_rss_feed' => '',
            'blog_rss_feed' => '',
            'blog_feed_title' => '',
            'blog_rss_feed' => '',
            'news_feed_title' => 'News',
            'news_rss_feed' => '',
            'news_rss_feed_number' => '',
            'blog_rss_feed_number' => '',
            'news_remove_image' => '',


        ), $atts));

        return render_component('LWeventsBlogsNews', [
            'main_rss_feed' => $main_rss_feed,
            'campus_rss_feed' => $campus_rss_feed,     
            'department_rss_feed' => $department_rss_feed,
            'blog_rss_feed' => $blog_rss_feed,
            'blog_feed_title' => $blog_feed_title,
            'news_rss_feed' => $news_rss_feed,
            'news_feed_title' => $news_feed_title,
            'news_rss_feed_number' => $news_rss_feed_number,
            'blog_rss_feed_number' => $blog_rss_feed_number,
            'news_remove_image' => $news_remove_image,
          

        ]);
    }

    add_shortcode('LWeventsBlogsNews', 'sc_LWeventsBlogsNews');

    vc_map(array(
        'name' => __('LW EBN'),
        'base' => 'LWeventsBlogsNews',
        'description' => __('Event Blog News LW.'),
        'icon' => THEME_PATH . '/assets/images/icons/calendar-week.svg',
        'params' => array(
            array(
                'type' => 'dropdown',
                'heading' => __( 'Events', '' ),
                'param_name' => 'main_rss_feed',
                'value' => array(
                  __('None', '') => '',
                  __('General', '') => '9',
                ),
                'description' => __( 'Select an event' ),
                'group' => 'Events',

              ),

              array( 
                'type' => 'dropdown',
                'heading' => __( 'Campuses', '' ),
                'param_name' => 'campus_rss_feed',
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
                'group' => 'Events',
              ),

              array( 
                'type' => 'dropdown',
                'heading' => __( 'Departments', '' ),
                'param_name' => 'department_rss_feed',
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
                'group' => 'Events',
              ),   
              
              array(
                'type' => 'textfield',
                'heading' => __("News Rss Feed Link"),
                'param_name' => 'news_rss_feed',
                'value' => '',
                'description' => __('Add Rss Feed url link to output most recent news post. ', ''),
                'group' => 'News',

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
              "value" => postNumbers2(),
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
          "value" => postNumbers2(),
          "description" => __('Sets number of rss feeds items in loop.', ''),
          'std' => 6,
      ),


       
    ));
}



function postNumbers2(){
  $numArray = [];
  for($i = 1; $i <= 10; $i++){
      array_push($numArray, $i);
  }
  return $numArray;
}
