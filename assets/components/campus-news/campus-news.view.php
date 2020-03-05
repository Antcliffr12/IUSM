<?php
require_once TEMPLATEPATH . '/assets/components/campus-news/campus-news.class.php';

$campus_news = isset($campus_news_rss_feed) ? $campus_news_rss_feed : 'No Campus Selected';
$url = "https://medicine.iu.edu/news/tag/$campus_news-campus/feed/";
//$url = "https://medicine.iu.edu/news/feed/?tag=$campus_news-campus'&feed=rss2";
$data = new CampusNewsFeed();

$newsCampus = !is_null($url) ? $data::GetFeed($url) : 'Something is wrong with Feed';
?>

<div id="content" class="campus-news-post">
  <div id="region-main">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="tag">
            <?php foreach ($newsCampus as $newsData) :

              $title = isset($newsData['title']) ? $newsData['title'] : '';
              $link = $newsData['link'];
              $content = $newsData['desc'];
              $date = $newsData['date'];
            //  $author = $newsData['author'];
              $author = isset($newsData['author']) ? $newsData['author'] : '';

              ?>
              <div class="post-container">
                <h2><a href="<?= $link ?>"><?= $title ?></a></h2>
                <p>
                  <?php
                 echo LimitText(strip_tags(preg_replace( '/\[[^\]]+\]/', '', $content)), 38)
                  ?>
                </p>
                <p class="details">By: <?php echo $author ?>
                On: <span class="date"><?=  date("F j, Y", strtotime($date))  ?></span>
                </p>
                 <?php echo do_shortcode('[addthis tool="addthis_inline_share_toolbox_7bqt"]'); ?>
              </div>
            <?php  endforeach;  ?>
            <div class="load-more">
              <div class="container">
                  <div class="col-md-12 text-center">
                      <a data-page="1" id="loadMore" data-url="<?php echo admin_url('admin-ajax.php') ?>" name="singlebutton" class=" btn-lg  btn btn-primary btn-big"><span>Load More</span></a>
                </div>
              </div>
            </div>
            <p class="totop">
                <a href="#top">Back to top</a>
            </p>
            <script>

            jQuery(".post-container").slice(0, 10).addClass('display');

            document.getElementById("loadMore").onclick = function(e){
                e.preventDefault();
              jQuery('.post-container:hidden').slice(0 ,10).addClass('display');
              if (jQuery(".post-container:hidden").length == 0) {
                  jQuery("#loadMore").fadeOut('slow');
              }
          }

          if (jQuery(".post-container:hidden").length == 0) {
              jQuery("#loadMore").hide();
          }

          jQuery('a[href=#top]').click(function () {
              jQuery('body,html').animate({
                  scrollTop: 0
              }, 600);
              return false;
          });

          jQuery(window).scroll(function () {
              if (jQuery(this).scrollTop() > 50) {
                  jQuery('.totop a').fadeIn();
              } else {
                  jQuery('.totop a').fadeOut();
              }
          });

          news = jQuery(".post-container").length;

          if(news == 0){

          }
            </script>

          </div>
          <div class="clearfix"></div>

        </div>
      </div>
    </div>
  </div>
</div>
