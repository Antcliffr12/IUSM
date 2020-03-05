<?php
/**
 * GOOGLE CUSTOM SEARCH DOCUMENTATION
 * https://developers.google.com/custom-search/docs/element
 */


get_header();
get_template_part('partials/header-content');

require_once TEMPLATEPATH . '/assets/components/search-results/search-results.class.php';

$search = new SearchResults([
    'query' => isset($_GET['s']) ? $_GET['s'] : '',
    'type' => isset($_GET['t']) ? $_GET['t'] : '' ,
    'version' => isset($_GET['v']) ? $_GET['v'] : '',
]);
$search_version = $search->version();
$is_author_search = $search->is_author_search();
$is_event_search = $search->is_event_search();
$is_news_search = $search->is_news_search();
$is_blogs_search = $search->is_blog_search();

$titleText = $is_author_search ? "Author Search Results For" : "Search Results For";
$textTile = $is_event_search ? "Event Search Results For" : "Search Results For ";
//$newsTitle = $is_news_search ? "News Search Results For" : "Search Results For ";
if($search_version == '1'){
  $newsTitle = $is_news_search ? "Latest Campus News For" : "Search Results For ";
}elseif($search_version == '2'){
  $newsTitle = $is_news_search ? "Latest Department News For" : "Search Results For ";
}elseif($search_version == '3'){
  $newsTitle = $is_news_search ? "Latest Department News For" : "Search Results For ";
}else{
  $newsTitle = $is_news_search ? "News Search Results For" : "Search Results For ";
}
// Setting Name correction based on author category search so it doesn't just display a number, rather displays a name.
$search_query = !is_null($search_version) && $search_version == '2' ? get_the_category_by_ID($search->raw_query()) : $search->raw_query();

if($is_author_search){ echo render_component('blog-menu', ['show_search' => 'false']); }
//if($is_event_search){ echo render_component('event-menu', ['show_search' => 'false']); }
if($is_news_search){ echo render_component('news-menu', ['show_search' => 'false']); }

if($is_blogs_search){ echo render_component('blog-menu', ['show_search' => 'false']); }




?>

<section id="content" class="search-results-content">

    <div class="container">
        <h2><?= $titleText ? $newsTitle  : "Search Results" ?> <span><?= $search_query ?></span></h2>
    </div>
    <div id="search-results-search-bar"
    class="<?php
     if($search_bar_class = $is_news_search){
        echo 'newsroom-search';}
        elseif($search_bar_class = $is_author_search){
          echo 'authors';
    }  elseif($search_bar_class = $is_blogs_search){
       echo 'newsroom-search';
    }
    else{
      echo '';
    }    ?>">
        <div class="container">
            <?php
            if($is_author_search){

                $url = get_home_url();
                $cat_args=array(
                    'orderby' => 'name',
                    'order' => 'ASC'
                );
                $categories = get_categories($cat_args);

                ?>
                <div class="col-md-6" style="padding-left:0px;">
                  <form role="search" method="get" action="<?= $url ?>">
                      <input type="hidden" value="author" name="t" />
                      <input type="hidden" value="0" name="v" />
                      <label for="authorSearch">Search for an Author</label>
                      <div class="search-input-cont">
                          <input id="authorSearch" aria-label="Author Search" type="text" name="s" placeholder="Search"/>
                          <span class="search-submit"><input type="submit" id="searchsubmit" value="<?= esc_attr__('Search')?>" /></span>
                      </div>
                  </form>
                </div>
                <div class="col-md-6 tablet-hide phone-hide" style="padding-left:0px;">
                  <form role="search" method="get" action="<?= $url ?>">
                      <label for="authorBlogSearch">View Authors By Subject</label>
                      <div class="select-cont">
                          <select id="authorBlogSearch" aria-label="Author Search by Blog" name="s">
                              <option value="0">Select a Blog</option>
                              <?php foreach($categories as $category):
                                  if ($category->term_id !== 1) {?>
                                      <option value="<?= $category->term_id ?>"><?= $category->name ?></option>
                                  <?php }
                              endforeach; ?>
                          </select>
                      </div>
                      <input type="hidden" value="author" name="t" />
                      <input type="hidden" value="2" name="v" />
                      <input type="submit" style="display:none;" value=""/>
                  </form>
                </div>



            <?php
            }elseif($is_event_search){
              $url = get_home_url();
            ?>
              <form role="search" method="get" action="<?= $url ?>">
                  <input type="hidden" value="event" name="t" />
                  <input type="hidden" value="0" name="v" />
                  <label for="eventSearch" class="hidden">Search Events</label>
                  <input aria-label="Event Search" type="text" name="s" placeholder="Search Events"/>
                    <span class="search-submit"><input type="submit" id="searchsubmit" value="<?= esc_attr__('Search')?>" /></span>
              </form>

            <?php
          }elseif($is_news_search){
          $url = get_home_url();
            ?>
            <div class="news-search">
                <div class="container">
                  <div class="row">
                    <div class="col-md-12">
                      <form role="search" method="get" action="<?= $url ?>">
                          <input type="hidden" value="news" name="t" />
                          <input type="hidden" value="0" name="v" />
                          <!--<label for="newsCampusSearch">News Search </label>-->
                          <div class="input-cont">
                              <input id="newsCampusSearch" aria-label="News Search" type="text" name="s" placeholder="News Search"/>
                              <input type="submit" value=""/>
                          </div>
                      </form>
                    </div><!-- col md 12 -->
                </div>
              </div>
          </div>
            <?php

          }
          elseif($is_blogs_search){
            $url = get_home_url();
              ?>
              <div class="news-search">
                  <div class="container">
                    <div class="row">
                      <div class="col-md-12">
                        <form role="search" method="get" action="<?= $url ?>">
                            <input type="hidden" value="blog" name="t" />
                            <input type="hidden" value="0" name="v" />
                            <div class="input-cont">
                                <input id="blogSearch" aria-label="Blog Search" type="text" name="s" placeholder="Blogs Search"/>
                                <input type="submit" value=""/>
                            </div>
                        </form>
                      </div><!-- col md 12 -->
                  </div>
                </div>
            </div>
              <?php
  
            }
          
          else{
              do_shortcode('[site-search placeholder="Search"]\']');
            }
            ?>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <?php
                // AUTHOR SEARCH
                if(isset($_GET['s']) && isset($_GET['t']) && isset($_GET['v'])){
                    $search->execute();
                }else{


                // SITE SEARCH
                ?>


                <script>
                    (function () {
                        var cx = '006262530976357608904:4wdm17il210';
                        var gcse = document.createElement('script');
                        gcse.type = 'text/javascript';
                        gcse.async = true;
                        gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
                        var s = document.getElementsByTagName('script')[0];
                        s.parentNode.insertBefore(gcse, s);
                    })();
                </script>
                <gcse:searchresults-only>

                <?php
                }
                ?>
            </div>
        </div>
</section>


<div id="section-footer" aria-label="Section Footer" class="bg-iu-cream">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-9 col-pos-1">
                <h4>IU School of Medicine | Office of Strategic Communications</h4>
                <div class="contact-info">410 W. 10th Street | HITS 3080 | Indianapolis, IN 46202 | iusm@iu.edu</div>
            </div>
            <div class="col-xs-12 col-sm-3 col-pos-2">
                <a class="button" href="mailto:iusm@iu.edu">CONTACT US</a>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
