<?php

// global $menu_tree;
// $menu_tree = new MenuTree('main');

global $extra_body_classes;
get_header();
get_template_part('partials/header-content');
echo render_component('news-menu');

$tagID = (isset($tag_id) && !empty($tag_id)) ? $tag_id :'';


/**
 * Set Query to pull latest featured post from a particular category setting.
 */
 $default_image = THEME_PATH . '/assets/images/Logo-Placeholder.png';
if (!empty($tagID)):
  $args = array(
      'posts_per_page' => 1,
      'meta_key' => 'featured_checkbox',
      'meta_value' => 'on',
      'tag__in' => $tagID,
  );
// else:
//     $args = array(
//         'posts_per_page' => 1,
//         'meta_key' => 'featured_checkbox',
//         'meta_value' => 'off',
//         'tag__in' => $tagID,
//
//     );
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


                         $is_featured = get_post_meta(get_the_ID(), 'featured_checkbox', true);
                          // $terms = get_terms('category');
                          // echo $terms;
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
                              <?php
                               $post_image_url  =  get_the_post_thumbnail_url($post->ID);
                               if(isset($post_image_url) && !empty($post_image_url)){
                                   ?>
                                   <div class="img-wrapper">
                                     <img src="<?= $post_image_url ?>" alt="<?= the_title() ?>"/>
                                     <div class="text-overlay">
                                       <a href="<?php the_permalink(); ?>">
                                        <h2><?php the_title(); ?></h2>
                                          </a>
                                          <p class="details"><?php echo $full_name; ?>
                                     &#8226; <span class="featured-date"><?php the_date('n/j/y'); ?></span>
                                          </p>
                                     </div>
                                  </div>
                                   <?php
                               }else{
                                 ?>
                                 <div class="img-wrapper">
                                   <img src="<?= $default_image ?>" alt="<?= the_title() ?>" />
                                    <div class="text-overlay">
                                      <a href="<?php the_permalink(); ?>">
                                        <h2><?php the_title(); ?></h2>
                                       </a>
                                       <p class="details"><?php echo $full_name; ?>
                                          &#8226; <span class="featured-date"><?php the_date('n/j/y'); ?></span>
                                       </p>
                                    </div>
                                 </div>
                                 <?php
                               }
                              ?>

                            </div>
                        <?php
                        if ( is_active_sidebar( 'blog_post_social_share' ) ) :
                            dynamic_sidebar( 'blog_post_social_share' );
                        endif;
                        endwhile;
                       }

                        if(!$is_featured){
                          $args = array(
                            'ignore_sticky_posts' => true,
                           'post_type'  => 'post',
                           'posts_per_page'=> 1,
                           'post__not_in' => $do_not_duplicate,
                           'post_status' => array('publish'),
                           'tag__in' => $tagID,
                       );

                         $query = new WP_Query( $args );
                         if($query->have_posts()) {
                           while ($query->have_posts()) : $query->the_post();
                           $do_not_duplicate[] = $post->ID;

                           $id = $featured_posts->post->ID;


                           $is_featured = get_post_meta(get_the_ID(), 'featured_checkbox', true);
                            // $terms = get_terms('category');
                            // echo $terms;
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
                                <?php
                                 $post_image_url  =  get_the_post_thumbnail_url($post->ID);
                                 if(isset($post_image_url) && !empty($post_image_url)){
                                     ?>
                                     <div class="img-wrapper">
                                       <img src="<?= $post_image_url ?>" alt="<?= the_title() ?>"/>
                                       <div class="text-overlay">
                                         <a href="<?php the_permalink(); ?>">
                                          <h2><?php the_title(); ?></h2>
                                            </a>
                                            <p class="details"><?php echo $full_name; ?>
                                       &#8226; <span class="featured-date"><?php the_date('n/j/y'); ?></span>
                                            </p>
                                       </div>
                                    </div>
                                     <?php
                                 }else{
                                   ?>
                                   <div class="img-wrapper">
                                     <img src="<?= $default_image ?>" alt="<?= the_title() ?>" />
                                      <div class="text-overlay">
                                        <a href="<?php the_permalink(); ?>">
                                          <h2><?php the_title(); ?></h2>
                                         </a>
                                         <p class="details"><?php echo $full_name; ?>
                                            &#8226; <span class="featured-date"><?php the_date('n/j/y'); ?></span>
                                         </p>
                                      </div>
                                   </div>
                                   <?php
                                 }
                                ?>

                              </div>
                          <?php
                          if ( is_active_sidebar( 'blog_post_social_share' ) ) :
                              dynamic_sidebar( 'blog_post_social_share' );
                          endif;
                          endwhile;
                         }
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

                        <?php if ($query->have_posts() ) : while ($query->have_posts()) : $query->the_post();
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

                         <p class="details">By: <?php echo $full_name; ?>
                         On: <span class="date"><?php the_time( get_option( 'date_format' ) ); ?></span>
                         </p>


                             <?php echo do_shortcode('[addthis tool="addthis_inline_share_toolbox_xtuu"]'); ?>
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
                              echo do_shortcode('[test]');
                              ?>
                              <div style="clear:both;"></div>
                          </div>
                          <div class="item copy-rss-feed">
                              <h2>Copy RSS FEED URL</h2>
                              <?php
                              $current_tag =  get_queried_object()->slug;

                              ?>
                              <label for="copy_feed">Copy RSS Feed URL</label>
                              <input type="text" name="copy_feed" class="copyToClipboard" readonly value="<?= site_url() ?>/feed/?tag=<?= $current_tag ?>'&feed=rss2" />
                          </div>
                      </div>
                    </div>
                    <!-- Contact Area -->

                    <div class="media-contacts">
                      <h3>Media Contacts</h3>
                      <div class="box">
                        <div class="item">
                          <div class="name-info">
                            <span class="glyphicon glyphicon-user"></span>
                            <div class="titles">
                            <h3>Name</h3>
                            <h2><?php
                            //Gets the ID of the tag.
                          $term_id =   get_queried_object()->term_id;

                          $name = get_term_meta($term_id, '_contact-name', true);
                          $name_results = (!empty($name)) ? $name : 'IU School of Medicine';
                          echo $name_results;

                            ?></h2>
                            </div>
                          </div>
                        </div>
                          <div class="item">
                            <div class="campus-info">
                              <span class="glyphicon glyphicon-map-marker"></span>
                                  <div class="titles">
                                    <?php
                                    // $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
                                    // $id = $author->ID;
                                    // $campus = get_the_author_meta( 'user_select',  $id );


                                    ?>
                                  <h3>Campus</h3>
                                  <h2><?php
                                  $campus = get_term_meta($term_id, '_contact-campus', true);
                                  $campus_selected = (!isset($campus) || empty($campus)) ? 'Indianapolis' : $campus;
                                  echo $campus_selected;
                                  ?></h2>
                                  </div>
                            </div>
                          </div>
                          <div class="item">
                            <div class="email-info">
                              <span class="glyphicon glyphicon-envelope"></span>
                                  <div class="titles">
                                    <h3>Email</h3>
                                    <h2>
                                      <?php
                                      $email = get_term_meta($term_id, '_contact-email', true);
                                      $email_results = (!empty($email)) ? $email : 'iusm@iu.edu';
                                       ?>
                                       <a href="mailto:<?php echo $email_results ?>"><?= $email_results ?></a>
                                    </h2>
                                    <!-- <h2><a href="mailto:iusm@iu.edu">iusm@iu.edu</a></h2> -->
                                  </div>
                            </div>
                          </div>
                          <div class="item">
                            <div class="phone-info">
                              <span class="glyphicon glyphicon-earphone"></span>
                              <div class="titles">
                                <h3>phone</h3>
                                <h2><?php
                                $phone = get_term_meta($term_id, '_contact-phone', true);
                                $phone_results = (!empty($phone)) ? $phone : '317-274-8157';
                                $formatted_number = preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $phone_results);

                                echo $formatted_number;
                                ?></h2>
                              </div>
                            </div>
                        </div>
                      </div>
                    </div> <!-- media contact -->



                </div>
              </div>
            </div>
          </div>
        </div>
<?php
get_footer();
?>
