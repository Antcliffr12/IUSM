<?php
require_once TEMPLATEPATH . '/assets/components/authors-featured/authors-featured.class.php';
//
$authorsAll = new AuthorsFeatured();
$setData = $authorsAll->set_usermeta();


$background = isset($bg_color) ? $bg_color : 'bg-white';
$heading = isset($heading) ? $heading : '';


?>
<div id="allAdvisingBlogAuthors" class="all-authors <?= $background ?>">
  <div class="container">

        <?php
        $args = array (
          'role' => 'Author',
            'meta_query' => array(
                array(
                    'key' => 'popularity',
                    'value' => array( 0, 10000 ),
                    'compare' => 'BETWEEN',
                    'type' => 'numeric',
                    'role' => 'Author'
                )
            ),
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
        );
        $user_query = new WP_User_Query($args);

        //$authors = get_users( 'role=author' );
        $authors = $user_query->get_results();


        ?>

    <?php if(!empty($heading)) : ?>
    <div class="row">
      <div class="col-sm-12">
        <h1><?= $heading ?></h1>
        </div>
      </div>
          <div class="row">
          <?php endif; ?>
          <?php
          foreach ( $authors as $author ) {
          $id = $author->ID;
          $data = get_userdata($author->ID);
          $name = $data->first_name . ' ' . $data->last_name;
          $name = !empty(trim($name)) ? $name : $data->display_name;
          $url = get_author_posts_url($author->ID);

          $views = get_the_author_meta('views', $id);
          // $shares = get_the_author_meta('views', $id);
          // $postCount = get_the_author_meta('postcount', $id);
          $popularity = get_the_author_meta('popularity', $id);
          ?>

              <div class="col-md-4 item" data-views="<?= $views ?>">
                <h2><a href="<?= $url?>"><?= $name ?></a></h2>
                <?php if(!empty($title)):?>
                  <p class="title">
                    <?= $title ?>
                  </p>
                <?php endif; ?>

              </div>
              <?php
              }
              ?>
    </div>
  </div>
</div>


<?php

wp_reset_postdata();
?>
