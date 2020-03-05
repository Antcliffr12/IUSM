<?php
/*
    Displays Category Page Content.
*/

get_header();
get_template_part('partials/header-content');
global $wp_query;
$category_id = get_queried_object_id();

echo render_component('blog-menu');
//echo render_component('blog-featured-post', ['bg_color' => 'bg-white', 'category_id' => $category_id, 'margin_adjust' => 'false']);
$args = array(
  'ignore_sticky_posts' => true,
  'post_type'  => 'post',
  'posts_per_page'=> 1,
  'post_status' => array('publish'),
  'cat' => $category_id,
  'order' => 'DESC',

);
$query = new WP_Query( $args );
if($query->have_posts()) {
?>
<section class="blog-featured-post padding-normal white" aria-label="featured post">
  <?php while ( $query->have_posts() ) : $query->the_post();
    $do_not_duplicate[] = $post->ID;
      $id = $query->post->ID;
      $terms = get_terms('category');
      $fname = get_the_author_meta('first_name');
      $lname = get_the_author_meta('last_name');
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
      $post_thumbnail = !empty(get_the_post_thumbnail($id, 'iu-blog-large')) ? get_the_post_thumbnail($id, 'iu-blog-large') : '';
      $second_col_class = !empty($post_thumbnail) ? 'class="col-md-6"' : 'class="col-md-12"';

      $link = get_author_posts_url($author_id);
      ?>
      <div class="container">
          <div class="row">
              <?php if (!empty($post_thumbnail)): ?>
                  <div class="col-md-6">
                      <a href="<?php the_permalink(); ?>"><?= $post_thumbnail ?></a>
                  </div>
              <?php endif; ?>
              <div <?= $second_col_class ?>>
                <span class="plugin-description">Featured Post</span>
                <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                <p class="excerpt"><?= limit_excerpt(30); ?></p>

                <p class="details"><a href="<?= $link ?>" class="author"><?php echo $full_name; ?></a>
                    &#8226; Date: <span class="date"><?php the_date('n/j/y'); ?></span>
                </p>
              </div>

          </div>
      </div>

      <?php endwhile; ?>
</section>
<?php
  }
?>
<?php
$args = array(
    'post_status' => array('publish'),
    'posts_per_page' => 8,
    'cat' => $category_id,
    'post__not_in' => $do_not_duplicate,
    'orderby' => 'date',
    'post_type' => 'post',
    'ignore_sticky_posts' => true,
    'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1,
);
$customQuery = new WP_Query($args);

$original_query = $wp_query;
$wp_query = $customQuery;

$post_array = [];
if ( $customQuery->have_posts() ) : ?>
    <div class="category-posts bg-iu-cream">
        <div class="container">
            <?php

            while ( $customQuery->have_posts() ) : $customQuery->the_post();
                //add to this array for visual componser code
                $shotcodes_tags = array( 'vc_row', 'vc_column', 'vc_column', 'vc_column_text', 'vc_message', 'iu_section_block' );

                $id = get_the_id();
                $content = get_post_field('post_content', $id);
                $content = preg_replace( '/\[(\/?(' . implode( '|', $shotcodes_tags ) . ').*?(?=\]))\]/', ' ', $content );


                
                $authorLink = get_the_author_posts_link(); // TODO:: Add to author name for link
                $default_image = get_stylesheet_directory_uri() . '/assets/images/Logo-Placeholder.png';
                $image = get_the_post_thumbnail($id, 'iu-blog-small');
                $image = (isset($image) && !empty($image)) ? $image : '<img src="'. $default_image . '" alt=""/>';

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
                $excerpt = (limit_content(15, $content));
                $author_id = get_post_field( 'post_author', $id );
                $link = get_author_posts_url($author_id);

                array_push($post_array, [
                    'id' => $id,
                    'image' => $image,
                    'excerpt' => $excerpt,
                    'full_name' => $full_name,
                    'date' => get_the_date('n/j/y', $id),
                    'link' => $link,
                ]);
            endwhile;
            ?>
            <div class="category-container" data-category="<?= get_the_category($id)[0]->name ?>">
                <?php
                if(!empty($post_array)) {
                    foreach (array_chunk($post_array, 4, true) as $postsRow):?>
                        <div class="row">
                            <?php foreach ($postsRow as $item) { ?>
                                <div class="col-4 col-lg-3 col-md-6 item" data-id="<?= $item['id'] ?>">
                                    <?php if (!empty($item['image'])): ?>
                                        <div class="image"><a
                                                    href="<?= get_the_permalink($item['id']) ?>"><?= $item['image'] ?></a>
                                        </div>
                                    <?php endif; ?>
                                    <h1>
                                        <a href="<?= get_the_permalink($item['id']) ?>"><?= get_the_title($item['id']) ?>
                                            <span class="arrow_right">&rarr;</span></a></h1>
                                    <?php if (!empty($item['excerpt'])) { ?>
                                        <p class="excerpt"><?= $item['excerpt'] ?></p>
                                    <?php } ?>
                                    <p class="details">
                                        <?php if (!empty($item['full_name'])) { ?>
                                            <a href="<?= $item['link'] ?>"><?= $item['full_name'] ?></a> &#8226;
                                        <?php } ?>
                                        <?= $item['date'] ?>
                                    </p>
                                </div>
                            <?php } ?>
                        </div>
                        <?php
                    endforeach;
                }
                ?>
            </div>

        </div>
    </div>
    <div class="category-posts-pagination">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="pagination">
                        <?php
                        the_posts_pagination(array(
                            'prev_text' => __('Previous', ''),
                            'next_text' => __('Next', ''),
                            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', '') . ' </span>',
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php
$wp_query = $original_query;
wp_reset_postdata();
?>

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
