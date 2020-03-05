<?php
 $backgroundColor = isset($bg_color) ? $bg_color : 'bg-iu-cream';
?>


<section class="blog-categories <?= $backgroundColor ?>">
    <div class="container">
        <?php
        global $post;
        $cat_args=array(
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => true,
            'exclude' => '1',
        );
        $categories = get_categories($cat_args);

        foreach(array_chunk($categories,3,true) as $categoryArray) { ?>
            <div class="row">
                <?php foreach ($categoryArray as $category) :
                    if ($category->term_id !== 1) {

                        $category_image = z_taxonomy_image_url($category->term_id, 'iu-medium');
                        $default_image = get_stylesheet_directory_uri() . '/assets/images/placeholder-360X240.png';
                        $category_image = (isset($category_image) && !empty($category_image)) ? $category_image : $default_image;

                        $excerpt = (limit_content(22, category_description($category->term_id)));
                        ?>
                        <div class="col-6 col-md-4 item" data-cat-id="<?= $category->term_id ?>">
                            <h1><a href="<?= get_category_link($category->term_id) ?>"><?= $category->name; ?>
                                    <span class="arrow_right"> &rarr;</span></a></h1>
                            <?php if (!empty($category_image)) { ?>
                                <div class="image">
                                    <a href="<?= get_category_link($category->term_id) ?>"><img
                                            src="<?= $category_image ?>"/></a>
                                </div>
                            <?php } ?>

                            <?php if (!empty($excerpt)) { ?>
                                <p class="excerpt"><?= $excerpt ?></p>
                            <?php } ?>
                        </div>
                    <?php }
                endforeach; ?>
            </div>
        <?php }
        ?>
    </div>
</section>