<?php
$url = get_home_url();
$showSearch = isset($show_search) ? $show_search : '';
$showSearch = empty($show_search) ? true : ($show_search == 'true' ? true : false);

if(isset($_POST['submit'])){
$email = $_POST['subscribe_news_email'];



}
?>
<div class="blog-menu">

    <div class="container">



        <div class="row-fluid" style="position:relative;">
            <nav aria-label="blog menu bottomNav" id="bottomNav">
              <a id="mobile-menu" class="btn-toggle-mobile-menu desktop-hide" href="#">
                &#9776;
              </a>


            <ul class="mobile-options">
                <li>
                  <a href="<?= esc_url( home_url( '/' ) ); ?>">Newsroom</a>
                </li>
                <li class="main-item add-flex">
                  <p>
                    Topics
                  </p>
                  <div class="dropdown-content">
                    <div class="one-fourth sub-menu">
                      <p class="dropdown-title">
                        Campus News
                      </p>
                      <ul class="dropdown-list campus">
                        <li>
                          <a href="<?= site_url() .'/tag/indianapolis-campus' ?>" tabindex="0">Indianapolis</a>
                        </li>
                        <li>
                          <a href="<?= site_url() .'/tag/bloomington-campus' ?>" tabindex="0">Bloomington</a>
                        </li>
                        <li>
                          <a href="<?= site_url() .'/tag/evansville-campus' ?>" tabindex="0">Evansville</a>
                        </li>
                        <li>
                          <a href="<?= site_url() .'/tag/fort-wayne-campus' ?>" tabindex="0">Fort Wayne</a>
                        </li>

                        <li>
                          <a href="<?= site_url() .'/tag/muncie-campus' ?>" tabindex="0">Muncie</a>
                        </li>
                        <li>
                          <a href="<?= site_url() .'/tag/gary-campus' ?>" tabindex="0">Gary </a>
                        </li>
                        <li>
                          <a href="<?= site_url() .'/tag/south-bend-campus' ?>" tabindex="0">South Bend</a>
                        </li>
                        <li>
                          <a href="<?= site_url() .'/tag/terre-haute-campus' ?>" tabindex="0"> Terre Haute</a>
                        </li>
                        <li>
                          <a href="<?= site_url() .'/tag/west-lafayette-campus' ?>" tabindex="0">West Lafayette</a>
                        </li>


                      </ul>
                    </div>
                    <div class="one-half sub-menu">
                      <p class="dropdown-title">
                        Topics
                      </p>
                      <ul class="dropdown-list departments">
                        <li>
                          <a href="<?= site_url() . '/tag/aging' ?>" tabindex="0">Aging</a>
                        </li>
                        <li>
                          <a href="<?= site_url() . '/tag/alzheimers-disease' ?>" tabindex="0">Alzheimer's Disease</a>
                        </li>
                        <li>
                          <a href="<?= site_url() . '/tag/cancer' ?>" tabindex="0">Cancer</a>
                        </li>
                        <li>
                          <a href="<?= site_url() . '/tag/diabetes' ?>" tabindex="0">Diabetes</a>
                        </li>
                        <li>
                          <a href="<?= site_url() . '/tag/education-programs' ?>" tabindex="0">Education Programs</a>
                        </li>
                        <li>
                          <a href="<?= site_url() . '/tag/global-health' ?>" tabindex="0">Global Health</a>
                        </li>

                        <li>
                          <a href="<?= site_url() . '/tag/indiana-health' ?>" tabindex="0">Indiana Health</a>
                        </li>
                        <li>
                          <a href="<?= site_url() . '/tag/musculoskeletal-health' ?>" tabindex="0">Musculoskeletal Health</a>
                        </li>
                        <li>
                          <a href="<?= site_url() . '/tag/pediatrics' ?>" tabindex="0">Pediatrics</a>
                        </li>
                        <li>
                          <a href="<?= site_url() . '/tag/personalized-medicine' ?>" tabindex="0">Personalized Medicine</a>
                        </li>
                        <li>
                          <a href="<?= site_url() . '/tag/research-findings' ?>" tabindex="0">Research Findings</a>
                        </li>
                      </ul>
                    </div>
                    <div class="one-fourth sub-menu">
                      <p class="dropdown-title">
                        Popular Topics
                      </p>
                      <ul class="dropdown-list topics">
                        <?php
                        $tags = get_tags();
                        if (empty($tags)){
                          echo '<p style="font-size:12px;">Sorry no Tags</p>';
                        }else{

                        $counts = $tag_links = array();
                        foreach ( (array) $tags as $tag ) {
                                $counts[$tag->name] = $tag->count;
                                $tag_links[$tag->name] = get_tag_link( $tag->term_id );
                        }
                        asort($counts);
                        $counts = array_reverse( $counts, true );
                        $i = 0;
                        foreach ( $counts as $tag => $count ) {
                                $i++;
                                $tag_link = clean_url($tag_links[$tag]);
                                $tag = str_replace(' ', '&nbsp;', wp_specialchars( $tag ));
                                if($i <= 5){
                                  ?>
                                  <li>
                                    <a href="<?= $tag_link ?>"><?= ucfirst($tag) ?></a>
                                  </li>
                                  <?php
                                }
                        }
                      }
                         ?>
                      </ul>
                    </div>
                  </div>
                </li>
                <li>
                  <a href="<?= site_url() .'/all-news' ?>">All News</a>
                </li>
                <li>
                  <a href="#">Subscribe</a>
                </li>
              </ul>
            </nav>
            <?php if($showSearch): ?>
                <div class="blog-search">
                  <form role="search" method="get" action="<?= $url ?>">
                      <input type="hidden" value="news" name="t" />
                      <input type="hidden" value="0" name="v" />
                      <label for="newsCampusSearch">News Search</label>
                      <div class="input-cont">
                          <input id="newsCampusSearch"  type="text" name="s" placeholder="Search News"/>
                          <input type="submit" value=""/>
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
                  <h1>Subscribe to News</h1>
                  <?php
                  echo do_shortcode('[test]');
                  ?>
                </div>

                <div class="copy-rss-url item">
                    <h1>Copy RSS feed URL</h1>
                    <?php
                    //$current_tag = single_tag_title("", false);
                    $current_tag =  get_queried_object()->slug;

                    $default_url = site_url() .'/feed/?tag=' . $current_tag .'&feed=rss2';
                    // $category_url = '';
                    // if(is_category() || is_single()){
                    //     $term_id = get_the_category()[0]->term_id;
                    //     $category_url = site_url() .'?cat='.$term_id.'&feed=rss2';
                    // }
                     $url = !empty($category_url) ? $category_url :$default_url;
                    ?>
                    <label style="display:none;" for="copy_feed">Copy RSS Feed URL</label>
                    <input type="text" name="copy_feed" id="copy_feed" class="copyToClipboard" readonly value="<?= $url ?>" />
                </div>


                <div class="view-all-blogs item">
                    <a href="<?= site_url(); ?>/news/">View All News</a>
                </div>
                <span class="subClose"><i class="fa fa-times" aria-hidden="true"></i></span>
            </div>
        </div>
    </div>
</div>
