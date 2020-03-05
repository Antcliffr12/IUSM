<?php
$background = isset($bg_color) ? $bg_color : 'bg-white';
$heading = isset($heading) ? $heading : '';
?>
<div id="allAdvisingBlogAuthors" class="all-authors <?= $background ?>">
  <div class="container">
    <?php
    /*
Views was a custom class already created so we query it, sort it and display
Show the number of times a posts as been clicked Wordpress numeric
  */
    $args = array(
      'role' => 'Author',
      'meta_query' => array(
          array(
              'key' => 'views',
              'value' => array( 0, 10000 ),
              'compare' => 'BETWEEN',
              'type' => 'numeric'
          )
      ),
      'orderby' => 'meta_value_num',
      'order' => 'DESC',
    );
    $user_query = new WP_User_Query($args);

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
if( ! empty($authors) ):
    foreach($authors as $author){
      $id = $author->ID;
      $user_info = get_userdata($author->ID);
      $views = get_the_author_meta('views', $id);

      $name = $author->first_name . ' ' . $author->last_name;
      $name = !empty(trim($name)) ? $name : $user_info->display_name;
      $url = get_author_posts_url($author->ID);
    ?>
        <div class="col-md-4 item" data-views="<?= $views ?>">
          <h2><a href="<?= $url ?>"><?=  esc_html( $name ) ?></a></h2>
          <?php if(!empty($title)):?>
            <p class="title">
              <?= $title ?>
            </p>
          <?php endif; ?>
        </div>
    <?php
    }
  else:
    ?>
    <div class="item">
        <div class="content">
            <p>No authors found.</p>
        </div>
    </div>
  <?php
  endif;
  ?>
    </div>
  </div>
</div><!-- allAdvisingBlog Authors -->
<?php
wp_reset_postdata();
?>
