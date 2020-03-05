<?php
/**
 * View template for component
 */
require_once TEMPLATEPATH . '/assets/components/enb/feed.php';

$eventsFeed = isset($events_rss_feeds) ? $events_rss_feeds : '';
$newsFeed = isset($news_rss_feeds) ? $news_rss_feeds : '';
$blogFeed = isset($blog_rss_feeds) ? $blog_rss_feeds : '';
$columnLayout = isset($layout) ? $layout : 'three_column';

if($columnLayout == 'three_column'){
    $col_one = 'col-md-4 col-md-push-4 col-sm-6';
    $col_two = 'col-md-4 col-md-push-4 col-sm-6';
    $col_three = 'col-md-4 col-md-pull-8';
}else if($columnLayout == 'two_column'){
    $col_one = 'col-sm-6';
    $col_two = 'col-sm-6';
    $col_three = 'col-sm-12';
}


?>
<div class="enb <?= $columnLayout ?>" data-component="Events / News / Blog">

    <div class="row">
        <div class="<?= $col_one ?> news">
        <h2>Campus News</h2>
            <?php
            if(!empty($newsFeed)):

                $count = 1;
                for($i = 0;$i <= $count - 1;$i++){
                    $rss = $newsFeed[$i];
                    $defaultImage = THEME_PATH . '/assets/images/IUSM-News-Placeholder.gif';
                    $image = (isset($rss['imageSrc']) && !empty($rss['imageSrc'])) ? '<img src="'. $rss['imageSrc'] .'" />' : '<img src="'. $defaultImage .'" />';
                    $title = (isset($rss['title']) && !empty($rss['title'])) ? $rss['title'] : '';
                    $link = (isset($rss['link']) && !empty($rss['link'])) ? $rss['link'] : '';
                    ?>
                    <a href="<?= $link  ?>" title="<?= $title ?>">
                        <?= $image ?>
                    </a>

                    <h3><a href="<?= $link ?>" title="<?= $title ?>"><?= $title ?></a></h3>

                    <?php
                }

             else:
                ?>
                 No Articles Found.
                <?php
            endif;
            ?>
      </div>
        <div class="<?= $col_two ?> blog">
        <h2>Recent Publications</h2>
        <ul>
          <?php
          if(!empty($blogFeed)):
              foreach($blogFeed as $rss) {
                  $title = (isset($rss['title']) && !empty($rss['title'])) ? $rss['title'] : '';
                  $link = (isset($rss['link']) && !empty($rss['link'])) ? $rss['link'] : '';
                  ?>
                  <li>
                      <a href="<?= $link  ?>" title="<?= $title ?>"><?= $title ?></a>
                  </li>
                  <?php
              }
          else:
            ?>
              <li>
                  No articles found.
              </li>
             <?php
          endif;
          ?>
        </ul>
      </div>
        <div class="<?= $col_three ?> events">
            <div class="event-wrapper">
            <h2>Seminars</h2>
                <div class="event-items">

                    <?php
                        if(!empty($eventsFeed)):
                            foreach($eventsFeed as $rss) {
                                $title = (isset($rss['title']) && !empty($rss['title'])) ? $rss['title'] : '';
                                $link = (isset($rss['link']) && !empty($rss['link'])) ? $rss['link'] : '';
                                $date = (isset($rss['description']) && !empty($rss['description'])) ? $rss['description'] : '';

                                    $date = !empty($date) ? strtotime(trim(strip_tags($date), ' ')) : '';

                                    $dateToFormat = (!empty($date) && $date !== false) ? $date : '';
                                    $month = '';
                                    $day = '';

                                    if(!empty($dateToFormat)):
                                        $month = date("M", $dateToFormat);
                                        $day = date("d", $dateToFormat);
                                    endif;
                                ?>
                                <div class="item" id="post-">
                                    <a href="<?= $link ?>" title="<?= $title ?>" class="event-date">
                                        <span class="month"><?= $month ?></span>
                                        <span class="day"><?= $day ?></span>
                                    </a>
                                    <a href="<?= $link ?>" title="<?= $title ?>" class="event-title"><?= $title ?></a>
                                    <div class="clearfix"></div>
                                </div>

                                <?php
                            }
                            else: ?>
                    <div>
                        No events found.
                    </div>
                    <?php endif; ?>


                </div>
            </div>
      </div>
    </div>
</div>
