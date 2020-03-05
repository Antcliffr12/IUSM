<?php
if( function_exists('vc_map')) {
  function sc_news_alert($atts = array()){

    extract(shortcode_atts(array(
      'title' => 'News Alerts',
      'body' => '',
      'url' => '',
      'no_alert' => '',

    ), $atts));

    return render_component('news-alert', [
      'title' => $title,
      'body' => $body,
      'url' => $url,
      'no_alert' => $no_alert,
    ]);
  }

  add_shortcode('news_alert', 'sc_news_alert');

  vc_map(array(
    'name' => __('News Alert Notification'),
    'base' => 'news_alert',
    'icon' => THEME_PATH . '/assets/components/news-alert/vc-icon.png',
    'description' => __('News Alert Notifcation Bar.'),
    'category' => __('IUSM Components'),
    'params' => array(
      array(
        "type" => "textfield",
        "heading" => __("Title"),
        "param_name" => "title",
        "value" => '',
        'std' => '',
        "description" => __("Title text to display above widget")
      ),
      array(
        "type" => "textarea",
        "heading" => __("Body"),
        "param_name" => "body",
        "value" => '',
        'std' => '',
        "description" => __("Body")
      ),
      array(
        "type" => "textfield",
        "heading" => __("URL"),
        "param_name" => "url",
        "value" => '',
        'std' => '',
        "description" => __("put url in the link to article")
      ),
      array(
          'type' => 'checkbox',
          'heading' => __('Displays Notifcation Bar.'),
          'description' => __('Check only if there is an important message.'),
          'param_name' => 'no_alert',
      ),
    ),
  ));
}
