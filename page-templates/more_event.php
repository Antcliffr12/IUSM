<?php
/*Template Name: More Events */
get_header();
get_template_part('partials/header-content');
$eventId = $_GET['eventId'];

$jsonURL = 'https://events.iu.edu/live/events/'.$eventId.'@JSON';
$jsonEvent = file_get_contents($jsonURL);
$jsonDecode = json_decode($jsonEvent, true);
$eventsCounter = count($jsonDecode);

// echo $jsonDecode['contact_info'];
// echo $jsonDecode['id'];
//encode for array conversion
$postID = $_GET['eventId'];
$Getyear = $jsonDecode['date_utc'];
$year = substr($Getyear, 0, 4);

?>
<div class="blog-menu">
    <div class="container">
        <div class="row-fluid" style="position:relative;">
            <nav aria-label="blog menu">
                <div class="menu-events-container">
                  <ul id="menu-events" class="menu">
                        <li data-menuid="18250" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-18250"><a href="<?php $current_url="http://".$_SERVER['HTTP_HOST']; ?>/events/?isToday=true" data-type="regular">Today</a></li>
                        <li data-menuid="18251" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-18251"><a href="<?php $current_url="http://".$_SERVER['HTTP_HOST']; ?>/events/?isToday=false" data-type="regular">This Week</a></li>
                        <li data-menuid="15503" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-15503"><a href="/events" data-type="regular">Subscribe</a></li>
                        <li data-menuid="18253" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-18253"><a href="<?php $current_url="http://".$_SERVER['HTTP_HOST']; ?>/events/"  data-type="regular">All Events</a></li>
                  </ul>
                </div>
            </nav>
        </div>
    </div>
    <div class="subscriptionItems bg-iu-crimson">
        <div class="container">
            <div class="row-fluid" style="position:relative;">
                <div class="copy-rss-url item">
                    <h1>Copy RSS feed URL</h1>
                                        <label style="display:none;" for="copy_feed">Copy RSS Feed URL</label>
                    <input type="text" name="copy_feed" id="copy_feed" class="copyToClipboard" readonly="" value="<?= $textBoxValue ?>">
                </div>
                <div class="view-all-blogs item">
                    <a href="<?= site_url( '/events/' ) ?>">View All Event</a>
                </div>
                <span class="subClose"><i class="fa fa-times" aria-hidden="true"></i></span>
            </div>
        </div>
    </div>
</div>

<div id="content" class="blog-single-post" style="padding-bottom:50px;">

<div id="region-main">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="post-container">
            <h1><?= $jsonDecode['title'] ?></h1>
              <div class="sub-heading">
                <?= $jsonDecode['date'] . ' ' . $year . ' ' . $jsonDecode['date_time'];   ?>
              </div>
              <p>
                <?php
                if(empty($jsonDecode['description'])){
                 echo $jsonDecode['summary'];
               }else{
                 echo $jsonDecode['description'];
               }
               ?>
              </p>
               <?php if(!empty($jsonDecode['contact_info'])){ ?>
              <p>Please Contact: <b><?= $jsonDecode['contact_info'] ?></b></p>           
               <?php } ?>
              <?php 
                if(!empty($jsonDecode['location'])){  ?>
              <div class="featured-event-location flex-vertical-spacing">
                <div class="featured-event-location-img"></div>
                <h3><a class="location_link" target="_blank" href="http://maps.google.com/?q=<?= $jsonDecode['location'] . ' ' . $jsonDecode['custom_room_number']; ?>"><?php            
               echo $jsonDecode['location'] . ' ' . $jsonDecode['custom_room_number'];             
               ?></a></h3>
              </div><!-- featured event location -->
            <?php } ?>
            </div><!-- post-container -->
          </div><!-- col md 8 -->
        </div><!-- row -->
      </div><!-- container -->
  </div><!-- region main -->
</div><!-- content -->

<?php 
get_footer();
