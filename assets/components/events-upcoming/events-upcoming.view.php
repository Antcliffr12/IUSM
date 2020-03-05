

<div class="events-upcoming" data-component="Upcoming Events">
    <h1>Upcoming Events</h1>


    <?php
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $today = date('m-d-Y g:i a');
    $counter = 3;
    $args = [
        'post_status' => 'publish',
        'post_type' => 'post',
        'meta_key' => 'start-date-time',
        'orderby' => 'meta_value',
        'order' => 'ASC',
        'category' => 'event',
        'posts_per_page' => $counter,
        'paged' => $paged,
//        'meta_query' => [
//            [
//                'key' => 'end-date-time',
//                'value' => $today,
//                'compare' => '>=',
//            ]
//        ],
    ];
    $query = new WP_Query($args);
    if ( $query->have_posts() ) {
        $count = $query->post_count;
        ?>
            <div class="the-events">
                <?php
                for($i = 0; $i <= $count - 1;$i++){
                    $post = $query->posts[$i];
                    $id = $post->ID;
                    $content = get_post_field('post_content', $id);
                    $content = str_replace(']]>', ']]&gt;', $content);

                    $location = get_post_meta($id, 'location', true);
                    $url = get_post_meta($id, 'event-url', true);
                    $start_date = get_post_meta($id, 'start-date-time', true);
                    $end_date = get_post_meta($id, 'end-date-time', true);
                    $contact_email = get_post_meta($id, 'contact-email', true);
                    $calendar_id = get_post_meta($id, 'calendar-id', true);
                    ?>

                    <div class="item" data-id="<?=$id?>">
                        <div class="date-square"></div>
                        <div class="content">
                            <span class="date"><?= $start_date ?></span>
                            <h2><?= get_the_title($id); ?></h2>
                            <p class="description"><?= $content ?></p>
                            <div class="lower">
                                <div class="location"><?= $location ?></div>
                                <a href="<?= $url ?>">I'm Going</a>
                            </div>
                        </div>
                        <hr />
                    </div>

                    <?php
                }
                ?>
                <div class="loaded-content"></div>
            </div>
        <?php
        if($count >= $counter){
            ?>
            <span class="load-more">Load More</span>
            <?php
        }
        ?>
        <span class="ajax-loader"><img src="<?= THEME_PATH . '/assets/components/events-upcoming/ajax-loader.gif'; ?>" /></span>
        <div class="count" style="display:none;"><?= $count ?></div>

        <noscript>
            <div class="events-upcoming-pagination">
                <div class="pagination">
                    <?php
                        $GLOBALS['wp_query']->max_num_pages = $query->max_num_pages;
                        the_posts_pagination( array(
                            'mid_size' => 1,
                            'prev_text' => __( 'Previous', '' ),
                            'next_text' => __( 'Next', '' ),
                            'screen_reader_text' => __( 'Events navigation' )
                        ) );
                    ?>
                </div>
            </div>
        </noscript>
    <?php } ?>
    <?php wp_reset_postdata(); ?>
</div>