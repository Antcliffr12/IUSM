<?php

if( function_exists('vc_map')) {
  function iu_social($atts = array())
  {
    extract(shortcode_atts(array(
      'twitter_username' => '',


    ), $atts));
    return render_component('iu-social', [
      'twitter_username' => $twitter_username
    ]);
  }
  add_shortcode('iu_social', 'iu_social');

  vc_map(array(
    'name' => __('IU Twitter'),
    'base' => 'iu_social',
    'description' => __('Displays recent posts of social media accounts'),
    'category' => __('IUSM Components'),
    'params' => array(
      array(
        'type' => 'textfield',
        'heading' => __('Twitter Username'),
        'param_name' => 'twitter_username',
        'value' => '',
        'description' => __('Twitter Username')
      ),
    ),
  ));
}
