<section id="content">
<div class="featured-event">
  <div class="container">
    <?php
    $args = array(
    "post_type" => "featured_event",
    "post_status"      => "publish",
    'meta_key'       => 'rss_feed',
    'meta_value' => 'yes',

    );
    $featured_post = get_posts($args);
    ?>

    <div class="featured-event-content">
      <?php
      if ($featured_post) {
      ?>
      <div class="col-md-6 col-sm-0 custom-featured">
        <?php
        foreach($featured_post as $post) :
          setup_postdata( $post );
          echo get_the_post_thumbnail( $post->ID, 'iu-blog-large', array( 'class' => 'img-responsive' ) );

          $startDate = get_post_meta( $post->ID,'start_date',true);
          $location = get_post_meta( $post->ID,'location',true);
          $start_time = get_post_meta( $post->ID,'start_time',true);
          $end_time = get_post_meta( $post->ID,'end_time',true);

           $date = new DateTime($startDate);

           $origDate = $startDate;

           $week = DateTime::createFromFormat('m-d-Y', $origDate);
           $DayOfWeek =  $week->format('D');
           $the_date = $week->format('D M d');


         ?>
      </div>
      <div class="featured-event-half col-md-6 col-sm-12">
        <div class="featured-event-info">
          <div class="featured-event-title flex-vertical-spacing">
            <h2><?= the_title() ?></h2>
          </div>
          <div class="featured-event-date flex-vertical-spacing">
            <?= $the_date . ' ' . $start_time . '-' . $end_time; ?>
          </div>
          <div class="featured-event-info-paragraph flex-vertical-spacing">
            <?php

            $more = '... <a href="' . esc_url(get_permalink( get_page_by_title( 'More Event')  ) ). '?eventId='. get_the_ID() .'&date='.$startDate .'">More</a>';
            $content = get_the_content();
            $trimmed_content = mb_strimwidth( $content, 0, 500, $more );
            echo $trimmed_content;
            ?>
          </div>
          <div class="featured-event-location flex-vertical-spacing">
            <div class="featured-event-location-img"> </div>
            <h3>
              <a target="_blank" class="location_link" href="http://maps.google.com/?q=<?= $location ?> "> <?= $location ?> </a>
            </h3>
          </div>

        </div>
      </div>
      <?php
    endforeach;
      ?>
      <?php
    }else{
      ?>
      <div class="featured-event-half col-md-6 col-sm-0 featured-image"></div>
      <div class="featured-event-half col-md-6 col-sm-12">
        <div class="featured-event-info-options">
          <!-- featured Event Area -->

        </div>
      </div>
      <?php
    }
      ?>
    </div>
  </div>
</div>
</section>