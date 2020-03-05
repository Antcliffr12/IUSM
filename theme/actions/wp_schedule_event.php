<?php

require_once TEMPLATEPATH . '/assets/components/authors-featured/authors-featured.class.php';

// Runs through and sets popularity value for each of the authors.
// Tied to /assets/components/authors-featured component
function author_featured_task(){
    $authorsFeatured = new AuthorsFeatured();
    $authorsFeatured->set_usermeta();
}

//https://developer.wordpress.org/plugins/cron/understanding-wp-cron-scheduling/
function cron_schedule($schedules){
    if(!isset($schedules["30min"])){
        $schedules["30min"] = array(
            'interval' => 1800,
            'display' => __('Once every 30 minutes'));
    }

    return $schedules;
}

add_filter('cron_schedules','cron_schedule');
add_action('authors_featured_scheduler', 'author_featured_task');
if (! wp_next_scheduled ( 'authors_featured_scheduler' )) {
    wp_schedule_event(time(), '30min', 'authors_featured_scheduler');
}


// Clear scheduled event in case the theme is deactivated.
add_action('switch_theme', 'theme_deactivation_function');
function theme_deactivation_function () {
    wp_clear_scheduled_hook('authors_featured_scheduler');
}


// wp_clear_scheduled_hook('authors_featured_scheduler');
// wp_clear_scheduled_hook('author_featured_task');