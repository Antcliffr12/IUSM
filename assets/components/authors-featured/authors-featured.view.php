<?php

//require_once TEMPLATEPATH . '/assets/components/authors-featured/authors-featured.class.php';
//
//$authorsFeatured = new AuthorsFeatured();
//$setData = $authorsFeatured->set_usermeta();

$i = 0;
?>

    <div class="authors-featured">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2>Popular Authors</h2>
                </div>
            </div>
            <div class="container">
                <div class="item-cont">
                    <?php
                    $args = array (
                        'meta_query' => array(
                            array(
                                'key' => 'popularity',
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

                    if(!empty($authors)):
                        foreach($authors as $author){
                            if ($i > 2) {break;}
                            $i += 1;
                            $id = $author->ID;
                            $data = get_userdata($id);
                            $name = $data->first_name . ' ' . $data->last_name;
                            $name = !empty(trim($name)) ? $name : $data->display_name;
                            $link = get_author_posts_url($id);
                            $title = get_the_author_meta('job_title',$id);
                            $title = isset($title) && !empty($title) ? $title : '';

                            $views = get_the_author_meta('views', $id);
                            $shares = get_the_author_meta('shares', $id);
                            $postCount = get_the_author_meta('postcount', $id);
                            $popularity = get_the_author_meta('popularity', $id);

                            $class= ' no-image';
                            $defaultImageClass = '';
                            $size = 'profile_image_medium';
                            $imgURL = "";
                            if(function_exists('get_cupp_meta')) {
                                $class = '';
                                $imgURL = get_cupp_meta($id, $size);
                                if (empty($imgURL)) {
                                    $class = '';
                                    $defaultImageClass = ' default-image';
                                    $imgURL = DEFAULT_AUTHOR_PROFILE_IMG;
                                }
                            }else {
                                $class = '';
                                $defaultImageClass = ' default-image';
                                $imgURL = DEFAULT_AUTHOR_PROFILE_IMG;
                            }

                            ?>
                            <div class="item" data-popularity="<?= $popularity ?>">
                                <?php if(!empty($imgURL)) {?>
                                    <div class="image">
                                        <a href="<?= $link ?>" aria-label="<?= $name ?>"><img src="<?= $imgURL ?>" alt=""/></a>
                                    </div>
                                <?php } ?>
                                <div class="content<?= $class ?>">
                                    <h2><a href="<?= $link ?>" aria-label="<?= $name ?>"><?= $name ?></a></h2>
                                    <p class="title"><?= $title ?></p>
                                    <ul>
                                        <li class="posts">Posts: <?= $postCount ?></li>
                                        <li class="views">Views: <?= $views ?></li>
                                        <li class="shares">Shares: <?= $shares ?></li>
                                    </ul>
                                </div>
                                <div style="clear:both;"></div>
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
        </div>
    </div>


<?php

wp_reset_postdata();
?>