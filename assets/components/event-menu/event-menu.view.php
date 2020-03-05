<?php
$url = get_home_url();
$showSearch = isset($show_search) ? $show_search : '';
$showSearch = empty($show_search) ? true : ($show_search == 'true' ? true : false);



?>
<div class="blog-menu">
    <div class="container">
        <div class="row-fluid" style="position:relative;">
            <nav aria-label="blog menu">
                <?php if (has_nav_menu('event')) {
                    wp_nav_menu( array(
                        'theme_location' => 'event',
                        'walker' => new blog_menu_walker(),
                    ) );
                } ?>
            </nav>
            <?php if($showSearch): ?>
                <div class="blog-search">
                    <form role="search">
                        <!-- <input type="hidden" value="event" name="t" />
                        <input type="hidden" value="0" name="v" /> -->
                        <label for="eventSearch">Search Events</label>
                        <div class="input-cont">
                            <input id="eventSearch" aria-label="Event Search" type="text" placeholder="Search Events" />
                            <input type="button" value=""/>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="subscriptionItems bg-iu-crimson">
        <div class="container">
            <div class="row-fluid" style="position:relative;">
                <div class="subscribe-to-blog item">
                  <h1>Subscribe to Events</h1>
                  <?php
                  global $post;
                  $cat_args=array(
                      'orderby' => 'name',
                      'order' => 'ASC'
                  );
                  $categories = get_categories($cat_args);
                  $categoryNames = '';
                  foreach($categories as $category) :
                      if($category->term_id !== 1) {
                          $categoryNames .= $category->name . ',';
                      }
                  endforeach;
                  echo do_shortcode('[stc-subscribe category_in="Event"]');
                  ?>
                </div>

                <div class="copy-rss-url item">
                    <h1>Copy RSS feed URL</h1>
                    <?php
                    $textBoxValue = 'https://events.iu.edu/live/json/events/group_id/9';
                    $default_url = $textBoxValue;
                    $category_url = '';
                    if(is_category() || is_single()){
                        $term_id = get_the_category()[0]->term_id;
                        $category_url = site_url() .'?cat='.$term_id.'&feed=rss2';
                    }
                    $url = !empty($category_url) ? $category_url :$default_url;
                    ?>
                    <label style="display:none;" for="copy_feed">Copy RSS Feed URL</label>
                    <input type="text" name="copy_feed" id="copy_feed" class="copyToClipboard" readonly value="<?= $url ?>" />
                </div>


                <div class="view-all-blogs item">
                    <a href="<?= site_url(); ?>/events">View All Events</a>
                </div>
                <span class="subClose"><i class="fa fa-times" aria-hidden="true"></i></span>
            </div>
        </div>
    </div>
</div>
