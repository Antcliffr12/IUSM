<?php
/**
 * View template for component
 */
 require_once TEMPLATEPATH . '/assets/components/event-news-blog-column/event-news-blog-column.class.php';
 require_once TEMPLATEPATH . '/assets/components/event-news-blog-column/event-news-blog-column-event.class.php';
 $defaultImage = THEME_PATH . '/assets/images/IUSM-Home-Blog-Placeholder.gif';

// $eventFeed = isset($event_rss_feed) ? $event_rss_feed : null;
$eventFeed = isset($main_rss_events) ? $main_rss_events : 'No Events Selected';
$campusFeed =isset($campus_rss_events) ? $campus_rss_events : 'No Events Selected';
$departmentFeed = isset($department_rss_events) ? $department_rss_events : 'No Events Selected';
$other_events = isset($other_events) ? $other_events : 'No Events Selected';

if($eventFeed){
  $url = 'https://events.iu.edu/live/json/events/group_id/'.$eventFeed.'';
}elseif($campusFeed){
  $url = 'https://events.iu.edu/live/json/events/category_id/'.$campusFeed.'/group_id/9/tag_id/';
}elseif($departmentFeed){
  $url = 'https://events.iu.edu/live/json/events/group_id/9/tag_id/'.$departmentFeed.'';
}
elseif($other_events){
    $url = 'https://events.iu.edu/live/json/events/category_id/13/group_id/9/tag_id/'.$other_events.'/';
}else{
  $url = 'Something is wrong with Feed';
}


$eventTitle = isset($event_feed_title) ? $event_feed_title : 'Events';
$eventCount = isset($event_rss_feed_number) ? $event_rss_feed_number : 5;


 $blogFeed = isset($blog_rss_feed) ? $blog_rss_feed : null;
 $blogTitle = isset($blog_feed_title) ? $blog_feed_title : '';
 $blogCount = isset($blog_rss_feed_number) ? $blog_rss_feed_number : 6;
 $has_title = $blogTitle == '' ? false : true;

 $newsFeed = isset($news_rss_feed) ? $news_rss_feed : null;
 $newsTitle = isset($news_feed_title) ? $news_feed_title : 'News';
 $newsCount = isset($news_rss_feed_number) ? $news_rss_feed_number : 1;
 $newsRemoveImage = isset($news_remove_image) ? $news_remove_image : false;
 $has_image = $newsRemoveImage == false ? true : false;



 $Edata = new FeedEvent();
 $data = new EventNewsBlogs_Feed();

//  $eventData = !is_null($eventFeed) ? $Edata::GetFeed($eventFeed) : '';
$eventData = !is_null($url) ? $Edata::GetEvents($url, date("Y-m-d")) : '';


 $blogData = !is_null($blogFeed) ? $data::GetFeed($blogFeed) : '';
 $newsData = !is_null($newsFeed) ? $data::GetFeed($newsFeed) : '';

$columnLayout = isset($layout) ? $layout : 'three_column';


if($columnLayout == 'three_column'){
  $col_one = 'col-md-4 col-md-push-4 col-sm-6';
  $col_two = 'col-md-4 col-md-push-4 col-sm-6';
  $col_three = 'col-md-4 col-md-pull-8';
}else if($columnLayout == 'two_column'){
    $col_one = 'col-sm-6';
    $col_two = 'col-sm-6';
    $col_three = 'hidden-lg';
    $display_none = 'hidden-lg';
}


?>
<div class="enb <?= $columnLayout ?>" data-component="event news blogs column">
  <div class="row">

    <div class="<?= $col_one ?> enb_news">
    <h2><?= $newsTitle ?></h2>
    <ul>

    <?php
    if(!empty($newsData)) {
        $i = 0;
        foreach($newsData as $newsItem):
        $i += 1;
        if($i > $newsCount){break;}
        $title = isset($newsItem['title']) ? $newsItem['title'] : '';
        $link = $newsItem['link'];

        if($has_image){
          echo '<li class="has_image">';
        }else{
        echo '<li>';
        }
    ?>
    <?php
    $imageSrc = isset($newsItem['image']) ? $newsItem['image'] : '';
    $imageSrc = !empty($imageSrc) ? $imageSrc : $defaultImage;
    ?>
    <?php
    if($has_image){ ?>
      <a style="padding:0;" href="<?= $link ?>" aria-label="<?= $title?>">
        <img src="<?= $imageSrc ?>" alt="" />
      </a>
    <?php
    }
     ?>
     <a href="<?= $link ?>"><?= $title ?></a>
     <div style="clear:both"></div>
    </li>
    <?php
    endforeach;
    }else{
    ?>
    <li>
      Feed Data unavailable.
    </li>
    <?php
    }
    ?>
  </ul>
    </div><!-- news -->
    <div class="<?= $col_two ?> blog">
      <h2><?= $blogTitle ?></h2>
      <?php
      if($has_title){
        echo '<ul class="has-title">';
      }else{
        echo '<ul class="no-title">';
      }
      ?>
      <?php
      if(!empty($blogData)){
        $i = 0;
        foreach($blogData as $blogItem):
          $i += 1;
          if($i > $blogCount){break;}
          $title = isset($blogItem['title']) ? $blogItem['title'] : '';
          $link = $blogItem['link'];
      ?>
      <li>
        <a href="<?= $link ?>"><?= $title ?></a>
      </li>
      <?php
    endforeach;
  }else{
    ?>
    <li>
      Feed Data unavailable.
    </li>
    <?php
    }
    ?>
    </ul>
  </div><!-- blog -->
  <div class="<?= $col_three ?> events">
    <h2><?= $eventTitle ?></h2>
    <div class="event-items">
      <?php
      if(!empty($eventData)){
        $i = 0;
        foreach($eventData as $events):
        $i += 1;
        if($i > $eventCount){break;}
          $title = isset($events['title']) ? $events['title'] : '';
          $link =  isset($events['url']) ? $events['url'] : '';
          $startDate = isset($events['date']) ? $events['date'] : '';
          $month = substr($startDate, 0, 3);
          $day = substr($startDate, 8,10);
          // $startDate = isset($events['start-date-time']) ? $events['start-date-time'] : '';
          // $endDate = isset($events['end-date-time']) ? $events['end-date-time'] : '';
          // $month = substr($startDate, 0, 2);
          // $day = substr($startDate, 3, 2);
          // $monthNum  = $month;
          // $dateObj   = DateTime::createFromFormat('!m', $monthNum);
          // $month = $dateObj->format('M'); // March

          ?>
          <div class="item" id="post-<?= the_ID(); ?>">
            <a href="<?= $link ?>" title="<?= $title ?>" target="_blank" class="event-date">
              <span class="month"><?= $month ?></span>
              <span class="day"><?= $day ?></span>
            </a>
            <a href="<?= $link ?>" title="<?= $title ?>" target="_blank" class="event-title">
              <?= $title ?>
            </a>
            <div class="clearfix"></div>
          </div>
          <?php

        endforeach;
      }else{
        echo '<b>Sorry no Events</b>';
      }


       ?>


    </div>
  </div><!-- events -->
</div>
</div>
