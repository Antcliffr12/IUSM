<div class="iu-events-bar" data-component="Events Bar">
    <h1><?= $title ?></h1>
    <div class="event-items row">

        <?php if($events->have_posts()) :
            while($events->have_posts()) : $events->the_post();
                ?>

                <div class="item clearfix col-xs-12 col-sm-4" id="post-<?php the_ID(); ?>">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="event-date"><span><?= get_the_date('M'); ?><br /><?= get_the_date('d'); ?></span></a>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="event-title"><?php the_title(); ?></a>
                </div>

                <?php
            endwhile;
        else:
            ?>
            <div class="item">
                <p>No events found.</p>
            </div>
            <?php
        endif;

        wp_reset_postdata();
        ?>
    </div>
</div>
