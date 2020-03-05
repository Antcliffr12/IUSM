<?php

global $menu_tree;
$menu_tree = new MenuTree('main');

global $extra_body_classes;
get_header();
get_template_part('partials/header-content');
echo render_component('news-menu');
$tagID = (isset($tag_id) && !empty($tag_id)) ? $tag_id :'';


if ( $post ) {
  $current_tag = single_tag_title("", false);
  $tag_id = get_queried_object()->term_id;
  $slug = get_queried_object()->slug;


    //gets site ID to change between blogs and news
}
/**
 * Set Query to pull latest featured post from a particular category setting.
 */
 $default_image = get_stylesheet_directory_uri() . '/assets/images/IUSM-Home-Blog-Category-Placeholder.gif';

if (!empty($tagID)):
  $args = array(
      'posts_per_page' => 1,
      'meta_key' => 'featured_checkbox',
      'meta_value' => 'on',
      'tag__in' => $tagID,
  );
else:
    $args = array(
        'posts_per_page' => 1,
        'meta_key' => 'featured_checkbox',
        'meta_value' => 'on',
    );
endif;

$featured_posts = new WP_Query($args);
?>
<div id="content" class="news-single-post">
    <div id="region-main">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-xs-12">
                    <div class="tag">
                      <?php
                       if($featured_posts->have_posts()) {
                         while ($featured_posts->have_posts()) : $featured_posts->the_post();
                         $do_not_duplicate[] = $post->ID;


                          $id = $featured_posts->post->ID;
                          $is_featured = get_post_meta($id, 'featured_checkbox', true);

                          $fname = get_the_author_meta('first_name');
                          $lname = get_the_author_meta('last_name');
                          // $author_id = get_the_author_meta('id');
                          $author_id = get_post_field('post_author', $id);
                          $full_name = '';
                          if (empty($fname)) {
                              $full_name = $lname;
                          } elseif (empty($lname)) {
                              $full_name = $fname;
                          } else {
                              //both first name and last name are present
                              $full_name = "{$fname} {$lname}";
                          }
                          $author_link_name = strtolower($fname) . "-" . strtolower($lname);

                          $link = get_author_posts_url($author_id);
                          ?>
                            <div class="text-wrapper">
                        <?php if ( has_post_thumbnail() ) { ?>

                              <div class="img-wrapper">
                                <?php the_post_thumbnail(  ); ?>
                                <div class="text-overlay">
                                    <a href="<?php the_permalink(); ?>">
                                 <h2><?php the_title(); ?></h2>
                                   </a>
                                 <p class="details"><a href="<?= $link ?>" class="author"><?php echo $full_name; ?></a>
                                     &#8226; <span class="featured-date"><?php the_date('n/j/y'); ?></span>
                                 </p>
                                </div>
                              </div>
                      <?php
                      }
                    endwhile;
                  }


                       // main post
                       $author = get_the_author();
                       $tag_id = get_queried_object_id();

                       $args = array(
                         'ignore_sticky_posts' => true,
                        'post_type'  => 'post',
                        'posts_per_page'=> 100,
                        'post__not_in' => $do_not_duplicate,
                        'post_status' => array('publish'),
                        'tag__in' => $tagID,



                    );
                    $query = new WP_Query( $args );

                      ?>
                        <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
                        $id = $post->ID;

                       $author_id = get_post_field('post_author', $id);
                       $fname = get_the_author_meta('first_name');
                       $lname = get_the_author_meta('last_name');
                       $full_name = '';
                       if (empty($fname)) {
                           $full_name = $lname;
                       } elseif (empty($lname)) {
                           $full_name = $fname;
                       } else {
                           //both first name and last name are present
                           $full_name = "{$fname} {$lname}";
                       }
                       $author = strtolower($fname) . "-" . strtolower($lname);

                       $link = get_author_posts_url($author_id);
                        ?>
                        <div class="post-container" data-tag="<?= get_the_tags($post->ID)[0]->slug ?>">
                           <h2><a href="<?= the_permalink(); ?>" >  <?= get_the_title(); ?></a></h2>
                         <p>
                           <?php
                         echo LimitText(strip_tags(preg_replace( '/\[[^\]]+\]/', '', get_the_content())), 38)
                           ?>
                         </p>

                         <p class="details">By: <a href="<?= $link ?>" class="news-author"><?php echo $full_name; ?></a>
                         On: <span class="date"><?php the_time( get_option( 'date_format' ) ); ?></span>
                         </p>


                             <?php echo do_shortcode('[addthis tool="addthis_inline_share_toolbox_9wk8"]'); ?>
                         </div>
                     <?php endwhile; ?>
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
                     <?php endif; ?>

                    </div>

                  <div class="clearfix"></div>

                </div>
                <div class="col-md-4 phone-hide sidebar-posts">
                  <div class="subscribe-to-blog">
                    <h3>Subscribe to The Newsroom</h3>
                      <div class="box">
                          <div class="item subscribe-via-email">
                              <h2>Subscribe Via Email</h2>
                              <?php
                            //  echo do_shortcode('[stc-subscribe category_in="'.$current_tag.'"]');


                              ?>
                              <div style="clear:both;"></div>
                          </div>
                          <div class="item copy-rss-feed">
                              <h2>Copy RSS FEED URL</h2>
                              <label for="copy_feed">Copy RSS Feed URL</label>
                              <input type="text" name="copy_feed" class="copyToClipboard" readonly value="<?= site_url() ?>/?tag=<?= $slug ?>&feed=rss2" />
                          </div>

                          <div class="item all-blogs">
                              <a href="<?= site_url(); ?>">View All Blogs</a>
                          </div>

                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
<?php
get_footer();
?>
