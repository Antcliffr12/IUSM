<?php
if( function_exists('vc_map')) {
    function sc_events($atts = array())
    {
        extract(shortcode_atts(array(
            'event_rss_feed' => '',
            'event_rss_feed_number' => '',

        ), $atts));

        return render_component('events', [
            'event_rss_feed' => $event_rss_feed,
            // 'event_rss_feed_number' => $event_rss_feed_number,
        ]);
    }

    add_shortcode('events', 'sc_events');

    vc_map(array(
        'name' => __('Events'),
        'base' => 'events',
        'description' => __('Displays Events through RSS Feed.'),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => __("Event Rss Feed Link"),
                'param_name' => 'event_rss_feed',
                'value' => '',
                'description' => __('Add Rss Feed url link to output most recent events post. ', ''),
            ),
            // array(
            //     "type" => "dropdown",
            //     "heading" => __("RSS Feed Length", ''),
            //     "param_name" => "event_rss_feed_number",
            //     "value" => show_num_events(),
            //     "description" => __('Sets number of events shown.', ''),
            //     'std' => 5,
            // ),

        ),
    ));
}
  // function show_num_events(){
  //   $number_events = [];
  //
  //   for($i = 1; $i <= 5; $i++)
  //   {
  //     array_push($number_events, $i);
  //   }
  //   return $number_events;
  // }
