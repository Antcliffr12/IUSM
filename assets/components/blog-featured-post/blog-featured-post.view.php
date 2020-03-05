<?php


$categoryID = (isset($category_id) && !empty($category_id)) ? $category_id :'';
$backgroundColor = (isset($bg_color) && !empty($bg_color)) ? $bg_color :'bg-iu-cream';
$marginAdjust = (isset($margin_adjust) && !empty($margin_adjust)) ? $margin_adjust : '';
$marginAdjust = (!empty($marginAdjust) && $marginAdjust == 'true') ? ' add-negative-margin' : '';
/**
 * Set Query to pull latest featured post from a particular category setting.
 */
if(!empty($categoryID)):
    $args = array(
        'posts_per_page' => 1,
        'meta_key' => 'featured_checkbox',
        'meta_value' => 'on',
        'category__in' => $categoryID,
    );
else:
    $args = array(
        'posts_per_page' => 1,
        'meta_key' => 'featured_checkbox',
        'meta_value' => 'on',
    );
endif;

$featured_posts = new WP_Query($args);
if($featured_posts->have_posts()) {
    ?>
    <section class="blog-featured-post padding-normal <?= $backgroundColor ?><?= $marginAdjust ?>" aria-label="featured post">
        <?php
        while ($featured_posts->have_posts()) : $featured_posts->the_post();
            $id = $featured_posts->post->ID;
            $is_featured = get_post_meta($id, 'featured_checkbox', true);
            $terms = get_terms('category');
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
                    <?php endif ?>

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
            <?php
        endwhile;
        ?>
    </section>
    <?php
}else {
    ?>
    <section class="blog-featured-post"></section>
    <?php
}
wp_reset_postdata();


?>
