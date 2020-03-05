<?php 
require_once TEMPLATEPATH . '/assets/components/LWeventsBlogsNews/LWeventsBlogsNews.class.php';

$eventFeed = isset($main_rss_feed) ? $main_rss_feed : 'No Events Selected';
$campusFeed =isset($campus_rss_feed) ? $campus_rss_feed : 'No Events Selected';
$departmentFeed = isset($department_rss_feed) ? $department_rss_feed : 'No Events Selected';

if($eventFeed){
    $url = 'https://events.iu.edu/live/json/events/group_id/'.$eventFeed.'';
}elseif($campusFeed){
    $url = 'https://events.iu.edu/live/json/events/category_id/'.$campusFeed.'/group_id/9/tag_id/';
}elseif($departmentFeed){
    $url = 'https://events.iu.edu/live/json/events/group_id/9/tag_id/'.$departmentFeed.'';
}else{
    $url = 'Something is wrong with Feed';
}

$data = new EventsFeed();

$eventData = !is_null($url) ? $data::GetEvents($url, date("Y-m-d")) : '';

