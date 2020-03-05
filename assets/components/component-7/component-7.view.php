<?php 

require_once TEMPLATEPATH . '/assets/components/events-dropdown/events-dropdown.class.php';

$eventFeed = isset($main_rss_events) ? $main_rss_events : 'No Events Selected';

$campusFeed =isset($campus_rss_events) ? $campus_rss_events : 'No Events Selected';

$departmentFeed = isset($department_rss_events) ? $department_rss_events : 'No Events Selected';

$other_events = isset($other_events) ? $other_events : 'No Events Selected';

$iu_state = isset($iu_state) ? $iu_state : 'No Events Selected';


$eventCount = isset($event_rss_feed_number) ? $event_rss_feed_number : 5;
//edit

if($eventFeed){
  $url = 'https://events.iu.edu/live/json/events/group_id/'.$eventFeed.'';
}elseif($campusFeed){
  $url = 'https://events.iu.edu/live/json/events/category_id/'.$campusFeed.'/group_id/9/tag_id/';
}elseif($departmentFeed){
  $url = 'https://events.iu.edu/live/json/events/group_id/9/tag_id/'.$departmentFeed.'';
}
elseif($other_events){
    $url = 'https://events.iu.edu/live/json/events/category_id/13/group_id/9/tag_id/'.$other_events.'/';
}
elseif($iu_state){
  $url = 'https://events.iu.edu/live/json/events/group_id/9/tag/'.$iu_state.'/';
}
else{
  $url = 'Something is wrong with Feed';
}

$data = new EventDropdownFeed();

// $EventFeed = !empty($url) ? $data::GetEvents($url) : 'Something is wrong with Feed';
$eventData = !is_null($url) ? $data::GetEvents($url, date("Y-m-d")) : '';
?>
<div class="component-7">
  <?php 
  if(!empty($eventData)){
    $i = 0;

    foreach($eventData as $events) :
      $i += 1;
      if($i > 3){break;}
      $title = isset($events['title']) ? $events['title'] : '';
      $link =  isset($events['url']) ? $events['url'] : '';
      $startDate = isset($events['date']) ? $events['date'] : '';

      $iu_date = substr($startDate,6,8);
      $iu = strip_tags($iu_date);
      $output = str_replace(',', ',', $iu_date);


      

      $month = substr($startDate, 0, 3);
      $day = substr($startDate, 8,8);
      $day = strip_tags($day);

     
      ?>
    <div class="item" id="post-<?= the_ID(); ?>">
      <div class="date">
          <div class="event-month">
            <?= $month ?>
          </div>
          <div class="event-day">
            <?= $day ?>
          </div>
      </div>
        <a href="<?= $link ?>" title="<?= $title ?>" target="_blank" class="event-title">
          <?= $title ?>
        </a>  
    </div>
      
  <?php 
 
    endforeach;
  }
  ?>
</div>