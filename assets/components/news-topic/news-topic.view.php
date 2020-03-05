
<div class="news-grid bg-iu-cream"  data-columns="3" data-component="Recent News Feed">
  <div class="container">
      <div class="row grid-items">
        <div class="three col-md-4 col-sm-12">
<?php
$research_posts = array( 'posts_per_page' => '1',
                'type' => 'post',
                'orderby' => 'date',
                'order' => 'DESC',
                'tag' => array('clinical-research, research-findings, research-funding'),
              );
//$recent_posts = wp_get_recent_posts( $args );
$recent_research_posts = new WP_Query($research_posts);
$defaultImage = THEME_PATH . '/assets/images/Logo-Placeholder.png';


  if($recent_research_posts->have_posts() ) :
    global $post;


    ?>
    <?php
    while($recent_research_posts->have_posts() ) : $recent_research_posts->the_post();

    ?>
    <a href="<?= site_url() ?>/tag/research-findings"><h3>Research</h3></a>

    <div class="image">

    <?php

    $post_image_url  =  get_the_post_thumbnail_url($post->ID);
    if(isset($post_image_url) && !empty($post_image_url)){
        ?>
        <img src="<?= $post_image_url ?>" alt="<?= the_title() ?>"/>
        <?php
    }else{
      ?>
      <img src="<?= $defaultImage ?>" alt="<?= the_title() ?>" />
      <?php
    }
     ?>
         </div>
     <?php
    endwhile;
    ?>

    <h3 class="title"><a href="<?= get_the_permalink() ?>"><?= get_the_title(); ?></a></h3>

    <?php
  endif;
wp_reset_postdata();
?>
</div>
<div class="three col-md-4 col-sm-12">

<?php
$education_posts = array( 'posts_per_page' => '1',
                'type' => 'post',
                'orderby' => 'date',
                'order' => 'DESC',
                'tag' => 'education-programs',
              );
//$recent_posts = wp_get_recent_posts( $args );
$recent_education_posts = new WP_Query($education_posts);
$defaultImage = THEME_PATH . '/assets/images/Logo-Placeholder.png';

  if($recent_education_posts->have_posts() ) :

    ?>


    <?php
    while($recent_education_posts->have_posts() ) : $recent_education_posts->the_post();

    ?>
    <a href="<?= site_url() ?>/tag/education-programs/"><h3>Education</h3></a>


    <div class="image">

    <?php
    $post_image_url  =  get_the_post_thumbnail_url($post->ID);
    if(isset($post_image_url) && !empty($post_image_url)){
        ?>
        <img src="<?= $post_image_url ?>" alt="<?= the_title() ?>"/>
        <?php
    }else{
      ?>
      <img src="<?= $defaultImage ?>" alt="<?= the_title() ?>" />
      <?php
    }
     ?>
       </div>
     <?php
    endwhile;
    ?>

     <h3 class="title"><a href="<?= get_the_permalink() ?>"><?= get_the_title(); ?></a></h3>
    <?php
  endif;
wp_reset_postdata();

?>
</div>
<div class="three col-md-4 col-sm-12">

<?php
$faculty_posts = array( 'posts_per_page' => '1',
                'type' => 'post',
                'orderby' => 'date',
                'order' => 'DESC',
                'tag' => 'faculty',
              );
//$recent_posts = wp_get_recent_posts( $args );
$recent_faculty_posts = new WP_Query($faculty_posts);
$defaultImage = THEME_PATH . '/assets/images/Logo-Placeholder.png';

  if($recent_faculty_posts->have_posts() ) :

    ?>


    <?php
    while($recent_faculty_posts->have_posts() ) : $recent_faculty_posts->the_post();
    ?>
    <a href="<?= site_url() ?>/tag/faculty"><h3>Faculty</h3></a>

    <div class="image">
    <?php
    $post_image_url  =  get_the_post_thumbnail_url($post->ID);
    if(isset($post_image_url) && !empty($post_image_url)){
        ?>
        <img src="<?= $post_image_url ?>" alt="<?= the_title() ?>"/>
        <?php
    }else{
      ?>
      <img src="<?= $defaultImage ?>" alt="<?= the_title() ?>" />
      <?php
    }
     ?>
         </div>
     <?php
    endwhile;
    ?>

    <h3 class="title"><a href="<?= get_the_permalink() ?>"><?= get_the_title(); ?></a></h3>

    <?php
  endif;
wp_reset_postdata();

?>
      </div>
    </div>
  </div>
</div>
