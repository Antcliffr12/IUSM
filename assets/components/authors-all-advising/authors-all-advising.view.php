<?php
$background = isset($bg_color) ? $bg_color : 'bg-white';
$heading = isset($heading) ? $heading : '';
?>
<div id="allAdvisingBlogAuthors" class="all-authors <?= $background ?>">
  <div class="container">
    <?php
    $args = array(
      'blog_id' => $GLOBALS['blog_id'],
      'role' => 'Author',
      'meta_key'     => '',
      'meta_value'   => '',
      'meta_compare' => '',
    );
    $user_query = new WP_User_Query($args);

    $authors = $user_query->get_results();
    //$test = get_users( $args );
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
    foreach($authors as $author){
      $id = $author->ID;
      $name = $author->first_name . ' ' . $author->last_name;
      $url = get_author_posts_url($author->ID);
    ?>
        <div class="col-md-4 item">
          <h2><a href="<?= $url ?>"><?=  esc_html( $name ) ?></a></h2>
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
</div><!-- allAdvisingBlog Authors -->
<?php

wp_reset_postdata();
?>
