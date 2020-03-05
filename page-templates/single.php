<?php
// global $menu_tree;
// $menu_tree = new MenuTree('main');

global $extra_body_classes;
get_header();
get_template_part('partials/header-content');
$site_id = get_current_blog_id();
if($site_id == 24){ //change to 9 for DEV
echo render_component('news-menu');

}else{
  echo render_component('blog-menu');
}
$post = get_post();
$term_id = '';
$category_name = '';
if ( $post ) {
    $categories = get_the_category( $post->ID );
    foreach ($categories as $k=>$cur) {
        $author_blog_name[] = $cur->cat_name;
        //$blog_slug = $cur->slug;
        $term_id = $cur->term_id;
        $category_name = $cur->name;
    }
    $author_blog_name = join(', ',$author_blog_name);
    $fname = get_the_author_meta('first_name');
    $lname = get_the_author_meta('last_name');
    $author_link_name = strtolower($fname) ."-". strtolower($lname);

    //gets site ID to change between blogs and news
}
?>
<div id="content" class="blog-single-post">
    <div id="region-main">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-xs-12">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <div class="post-container" data-category="<?= get_the_category($post->ID)[0]->name ?>">
                            <h1><?php the_title(); ?></h1>
                            <?php

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
                            $author_link_name = strtolower($fname) ."-". strtolower($lname);
                            $author_id = get_the_author_meta('ID');
                            $link = get_author_posts_url($author_id);
                            ?>

                            <div class="sub-heading">
                              <?php if ($site_id !== 24){ ?>
                              <a href="<?= $link ?>">
                              <?php } ?>
                                <?= $full_name ?>

                              </a>
                               &#8226; <?= get_the_date('n/j/y');?>
                            </div>


                            <?php
                                if ( is_active_sidebar( 'blog_post_social_share' ) ) :
                                    dynamic_sidebar( 'blog_post_social_share' );
                                endif;
                             ?>

                            <?php
                            if ($site_id != 24 ){ //cha
                            $post_image_url  =  get_the_post_thumbnail_url($post->ID);
                            if(isset($post_image_url) && !empty($post_image_url)){
                                ?>
                                <img src="<?= $post_image_url ?>" alt="<?= the_title() ?>"/>
                                <?php
                            }
                          }


                            ?>
                            <?php the_content(); ?>
                            <?php
                            if ($site_id != 24 ){ //change to 9 for DEV
                            ?>
                            <div class="author-box">
                                <div class="row">
                                    <?php
                                    $class = 'col-sm-12';
                                    if(function_exists('get_cupp_meta')):
                                        // REF:: https://wordpress.org/plugins/custom-user-profile-photo/
                                        $size = 'profile_image_small';
                                        $imgURL = get_cupp_meta(get_the_author_meta('ID'), $size);
                                        $imgURL = !empty($imgURL) ? $imgURL : DEFAULT_AUTHOR_PROFILE_IMG;
                                            $class='col-sm-10';
                                        ?>
                                        <div class="col-sm-2 hidden-xs">
                                            <img src="<?= $imgURL ?>" alt=""/>
                                        </div>
                                        <?php
                                    else:
                                        if(function_exists('get_avatar')) {
                                            $class='col-sm-10';
                                            $imgURL = DEFAULT_AUTHOR_PROFILE_IMG;
                                        ?>
                                            <div class="col-sm-2 hidden-xs">
                                                <img src="<?= $imgURL ?>" alt="" />
                                            </div>
                                        <?php }
                                    endif;
                                    ?>

                                    <div class="<?= $class ?>" data-autho-id="<?= $author_id?>">
                                        <p class="heading"><strong>Author</strong></p>
                                        <?php
                                        echo '<h3><a href="'. $link .'">'. $full_name.'</a></h3>';
                                        ?>

                                        <?php
                                        $job_title = get_the_author_meta( 'job_title',  get_the_author_meta('ID'));
                                        if(isset($job_title) && !empty($job_title)) {
                                            echo '<p class="title">'.$job_title.'</p>';
                                        }
                                        ?>
                                        <p class="description"><?php $authorDesc = the_author_meta('description'); echo $authorDesc; ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php
                          }
                            ?>
                        </div>
                    <?php endwhile; ?>
                    <?php endif; ?>
                    <div class="clearfix"></div>

                </div>
                <div class="col-md-4 sidebar-posts">
                  <?php   if ($site_id == 24 ){ //cha ?>
                  <div class="post-image phone-hide">

                    <?php
                    //caption for featured image in News
                    $get_caption = get_post(get_post_thumbnail_id())->post_excerpt;

                    $post_image_url  =  get_the_post_thumbnail_url($post->ID);
                    if(isset($post_image_url) && !empty($post_image_url)){
                        ?>
                        <img src="<?= $post_image_url ?>" alt="<?= the_title() ?>"/>
                        <?php if (!empty($get_caption)){
                        echo '<div class="featured-news-post-caption"><p class="wp-caption-text">' . $get_caption . '</p></div>';
                      }//end if

                    }//end if

                  ?>
                  </div>
                <?php } ?>


                  <?php if($site_id != 24) { ?>
                    <div class="suggested-for-you phone-hide">
                        <h3>Suggested For You</h3>
                        <div class="box">
                          <?php
                          global $post;

                          $term_list = wp_get_post_terms($post->ID, 'category', array("fields" => "ids"));
                          $related_args=array(
                            'post__not_in' => array($post->ID),
                            'posts_per_page'=>4, // Number of related posts to display.
                            'ignore_sticky_posts'=> true,
                            'category__not_in' => 1,
                            'tax_query' => array(
                                    array(
                                        'taxonomy' => 'category',
                                        'terms'    => $term_list,
                                    ),
                                ),
                          );

                          $related = new WP_Query($related_args );
                          if($related->have_posts() ) {
                            while ($related->have_posts() ) : $related->the_post();
                          ?>
                          <div class="item">
                            <?php $categories = get_the_category(); ?>

                            <h2><?= esc_html( $categories[0]->name );    ?></h2>
                            <a href="<?= the_permalink(); ?>"><?= the_title(); ?></a>
                          </div>
                          <?php
                          endwhile;
                          }else{
                          ?>
                                <div class="item">
                                    <p>No suggestions found at this time.</p>
                                </div>
                          <?php
                          }
                          ?>


                        </div>
                    </div>
                    <?php
                  }
                    ?>
                    <div class="subscribe-to-blog phone-hide">
                      <?php if($site_id != 24){ ?>
                        <h3>Subscribe to This Blog</h3>
                      <?php
                    }else{
                      ?>
                        <h3>Subscribe to The Newsroom</h3>
                      <?php
                    }
                      ?>
                        <div class="box phone-hide">
                            <div class="item subscribe-via-email">
                                <h2>Subscribe Via Email</h2>
                                <?php
                                 if($site_id != 24){
                                echo do_shortcode('[stc-subscribe]');
                              }else{
                                echo do_shortcode('[test]');
                              }
                                ?>
                                <div style="clear:both;"></div>
                            </div>
                            <div class="item copy-rss-feed">
                                <h2>Copy RSS FEED URL</h2>
                                <label for="copy_feed">Copy RSS Feed URL</label>
                                <?php if($site_id != 24){ ?>
                                <input type="text" name="copy_feed" class="copyToClipboard" readonly value="<?= site_url() ?>/?cat=<?= $term_id ?>&feed=rss2" />
                              <?php }else{ ?>

                                <?php
                                $post_tags = get_the_tags();
                                // if ( $post_tags ) {
                                //     echo $post_tags[0]->slug;
                                // }
                                $current_tag =  get_queried_object()->slug;

                                ?>
                                <label for="copy_feed">Copy RSS Feed URL</label>
                                <input type="text" name="copy_feed" class="copyToClipboard" readonly value="<?= site_url() ?>/feed/?tag=<?= $post_tags[0]->slug; ?>&feed=rss2" />
                              <?php } ?>
                            </div>
                            <?php if($site_id != 24){ ?>
                            <div class="item all-blogs">
                                <a href="<?= site_url(); ?>">View All Blogs</a>
                            </div>
                          <?php } ?>
                        </div>
                    </div>
                    <?php
                    if($site_id == 24){
                    ?>
                    <div class="media-contacts">
                      <h3>Media Contacts</h3>
                      <div class="box">
                        <div class="item">
                          <div class="name-info">
                            <span class="glyphicon glyphicon-user"></span>
                            <div class="titles">
                            <h3>Name</h3>
                            <?php
                            $name =  get_post_meta( $post->ID, '_contact-name', true );
                            $name_results = (!empty($name)) ? $name : 'IU School of Medicine';
                            ?>
                            <h2><?= $name_results; ?></h2>
                            </div>
                          </div>
                        </div>
                          <div class="item">
                            <div class="campus-info">
                              <span class="glyphicon glyphicon-map-marker"></span>
                                  <div class="titles">
                                    <?php
                                      $campus = get_post_meta($post->ID, '_contact-campus', true);
                                      $campus_selected = (!isset($campus) || empty($campus)) ? 'Indianapolis' : $campus;
                                    ?>
                                  <h3>Campus</h3>
                                  <h2><?= $campus_selected ?></h2>
                                  </div>
                            </div>
                          </div>
                          <div class="item">
                            <div class="email-info">
                              <span class="glyphicon glyphicon-envelope"></span>
                                  <div class="titles">
                                    <?php
                                    $email = get_post_meta($post->ID, '_contact-email', true);
                                    $email_results = (!empty($email)) ? $email : 'iusm@iu.edu';

                                    ?>
                                    <h3>Email</h3>
                                    <h2> <a href="mailto:<?php echo $email_results ?>"><?= $email_results ?></a></h2>
                                  </div>
                            </div>
                          </div>
                          <div class="item">
                            <div class="phone-info">
                              <span class="glyphicon glyphicon-earphone"></span>
                              <div class="titles">
                                <?php
                                $phone = get_post_meta($post->ID, '_contact-phone', true);
                                $phone_results = (!empty($phone)) ? $phone : '317-274-8157';
                                $formatted_number = preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $phone_results);

                                 ?>
                                <h3>phone</h3>
                                <h2><?php echo $formatted_number; ?></h2>
                              </div>
                            </div>
                        </div>
                      </div>
                    </div> <!-- media contact -->
                    <?php
                    }
                    if($site_id == 24){
                  ?>
                  <div class="related-news phone-hide">
                        <h3>Related News</h3>
                        <div class="box">
                          <?php

                          $tags = wp_get_post_tags($post->ID);
                          if ($tags) {
                                $first_tag = $tags[0]->term_id;
                                $args = array('tag__in' => array($first_tag),
                                              'post__not_in' => array($post->ID),
                                              'posts_per_page'=>5,
                                              'caller_get_posts'=>1
                                            );

                              $my_query = new WP_Query($args);

                              if($my_query->have_posts()) {
                                  while ($my_query->have_posts()) {
                                      $my_query->the_post();
                                      ?>
                                      <div class="item">

                                        <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                      </div>
                                      <?php
                                  }
                              }else{
                                  ?>
                                  <div class="item">
                                      <p>No suggestions found at this time.</p>
                                  </div>
                                  <?php
                              }
                            }else{
                                ?>
                                <div class="item">
                                    <p>No suggestions found at this time.</p>
                                </div>
                                <?php
                            }

                          $post = $orig_post;
                          wp_reset_query();
                          ?>

                        </div>
                  </div><!-- related news -->
                  <?php
                }
                  ?>
                </div>
            </div>
        </div>
    </div>
</div>





    <div id="section-footer" aria-label="Section Footer" class="bg-iu-cream">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-9 col-pos-1">
                    <h4>IU School of Medicine | Office of Strategic Communications</h4>
                    <div class="contact-info">410 W. 10th Street | HITS 3080 | Indianapolis, IN 46202 | iusm@iu.edu</div>
                </div>
                <div class="col-xs-12 col-sm-3 col-pos-2">
                    <a class="button" href="/communications/contacts/">CONTACT US</a>
                </div>
            </div>
        </div>
    </div>





<?php get_footer(); ?>
