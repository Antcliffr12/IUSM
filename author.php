<?php

get_header();
get_template_part('partials/header-content');
echo render_component('blog-menu');

$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
$id = $author->ID;

$pid = get_the_author_meta( 'iu_personal_id', $id );
$pid = isset($pid) && !empty($pid) ? $pid : '';
$twitter = get_the_author_meta('twitter');
// $googlePlus = get_the_author_meta('googleplus');
$facebook = get_the_author_meta('facebook');

$link = get_the_author_meta('url');
$link = preg_replace('#^https?://#', '', $link);

// Load Faculty Data API
require_once('FacultyData.php');
$faculty_info = '';

try {
    if(!empty($pid)){
        // 4.4.17 Untested, code added though based on given logic elsewhere.
        $faculty_info = new \IU\FacultyData($pid);
        $first_name = $faculty_info->first_name;
        $last_name = $faculty_info->last_name;
        $url_name = strtolower(str_replace(' ', '-', "{$last_name}-{$first_name}"));
        $url_name = preg_replace('@[^-a-z]@', '', $url_name);
        $link = $pid .'/'. $url_name. '/';
    }
}catch(\Exception $ex){
    echo "<div class=\"alert alert-danger\" role=\"alert\">{$ex->getMessage()}</div>\n";
}
if(!empty($link)){
$url = network_site_url( '/faculty/'. $link);
}
// echo $url;

?>

    <div id="content" class="author-post">
        <div id="region-main">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-xs-12">
                        <?php

                        $fname = get_the_author_meta('first_name');
                        $lname = get_the_author_meta('last_name');
                        $full_name = '';
                        if (empty($fname)) {
                            $full_name = $lname;
                        } elseif (empty($lname)) {
                            $full_name = $fname;
                        } else {
                            //both first name and last name are present
                            $full_name = "{$fname} {$lname}";
                        }

                        $job_title = get_the_author_meta( 'job_title',  $id);
                        $job_title = isset($job_title) && !empty($job_title) ? $job_title : '';

                        $description = get_the_author_meta('description', $id);
                        $description = isset($description) && !empty($description) ? $description : '';


                        // Add Author Profile Image.
                        // REF:: https://wordpress.org/plugins/custom-user-profile-photo/
                        $class = 'col-sm-12';
                        $size = 'profile_image_large';
                        $imgURL = "";
                        if(function_exists('get_cupp_meta')):
                            $class = 'col-sm-8';
                            $imgURL = get_cupp_meta($id, $size);
                            $imgURL = !empty($imgURL) ? $imgURL : DEFAULT_AUTHOR_PROFILE_IMG;
                        else:
                            $class = 'col-sm-8';
                            $imgURL = DEFAULT_AUTHOR_PROFILE_IMG;
                        endif;

                        ?>

                        <div class="author-id-card bg-iu-cream">
                            <div class="container">
                                <div class="row">
                                    <?php if(!empty($imgURL)){?>
                                        <div class="col-sm-4">
                                            <div class="image">
                                                <img src="<?= $imgURL ?>" alt="" />
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="<?= $class ?>">
                                        <div class="content">
                                            <h1><?= $full_name ?></h1>
                                            <?php if(!empty($job_title)) {?>
                                                <p class="title"><?= $job_title?></p>
                                            <?php } ?>
                                            <?php if(!empty($description)){?>
                                                <p class="description"><?= $description ?></p>
                                            <?php } ?>

                                            <?php if(!empty($url)) {?>
                                                <a href="<?= $url ?>" class="full-profile-link">View Full Profile</a>
                                            <?php } ?>

                                            <div style="margin-top: 35px; padding:10px 0 10px 0;">
                                              <!-- twitter -->
                                              <?php if(!empty($twitter )){ ?>
                                              <a style="text-decoration:none; margin-right:15px;" target="_blank" href="https://twitter.com/<?= $twitter ?>">
                                                <img style="width:40px; height:40px;" class="icon-twitter" src="<?= THEME_PATH ?>/assets/images/icon-footer-twitter.svg">
                                              </a>
                                              <?php } ?>
                                              <!-- facebook -->
                                              <?php if(!empty($facebook)){ ?>
                                                  <a style="text-decoration:none;" target="_blank" href="https://facebook.com/<?= $facebook ?>">
                                                <img style="width:40px; height:40px;" class="icon-facebook" src="<?= THEME_PATH ?>/assets/images/icon-footer-facebook.svg">
                                              <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="author-posts">
                            <h1>My Posts</h1>
                            <?php
                            $args = array(
                                'author'        =>  $id,
                                'orderby'       =>  'post_date',
                                'order'         =>  'DESC',
                            );
                            $posts = new WP_Query($args);
                            ?>
                            <div class="posts">
                                <?php
                                if ($posts->have_posts()) :
                                    while ($posts->have_posts()) : $posts->the_post();
                                        $post_id = get_the_ID();
                                        $category_name = get_the_category()[0]->name;
                                        $category_link = get_category_link(get_the_category()[0]->term_id);
                                        $date = get_the_date('n/j/y');
                                        $title = get_the_title();
                                        ?>
                                        <div class="item" data-id="<?= $post_id ?>">
                                            <h2><a href="<?= get_the_permalink()?>"><?=$title?></a></h2>
                                            <p>Blog: <a href="<?= esc_url( $category_link ); ?>"><?=$category_name?></a> &#8226; Date: <?= $date ?></p>
                                        </div>
                                        <?php
                                    endwhile;
                                endif;
                                wp_reset_query();
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 phone-hide sidebar-posts">
                        <div class="contributed-blogs">
                            <h1>Blogs I Contribute</h1>
                            <ul>
                                <?php
                                $categories = get_terms("category");
                                $data = [];
                                if(!empty($categories)){
                                    foreach($categories as $category)
                                    {
                                        $category_name = $category->name;
                                        $category_id = $category->term_id;
                                        if($category_id !== 1) {  // exclude uncategorized.
                                            $category_link = get_term_link($category_id);
                                            $args = array(
                                                'author'        =>  $author->ID,
                                                'cat'           =>  $category_id,
                                            );
                                            $posts = new WP_Query($args);
                                            $post_count = $posts->post_count;
                                            if ($post_count > 0) {
                                                array_push($data, [
                                                    'category_id' => $category_id,
                                                    'category_link' => $category_link,
                                                    'category_name' => $category_name
                                                ]);


                                                ?>

                                            <?php }
                                        }
                                    }
                                    if(!empty($data)){
                                        foreach($data as $item){
                                            $category_id = isset($item['category_id']) ? $item['category_id'] : '';
                                            $category_link = isset($item['category_link']) ? $item['category_link'] : '';
                                            $category_name = isset($item['category_name']) ? $item['category_name'] : '';
                                            ?>
                                            <li data-termId="<?= $category_id ?>"><a href="<?= $category_link ?>"><?= $category_name ?><span class="arrow_right"> &rarr;</span></a></li>
                                        <?php }
                                    }else{ ?>
                                        <li class="empty">Not Available.</li>
                                    <?php }
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="subscribe-to-blog author">
                            <h1>Subscribe to This Blog</h1>
                            <div class="box">
                                <div class="item subscribe-via-email">
                                    <h2>Subscribe Via Email</h2>
                                    <?php
                                    global $post;
                                    $cat_args=array(
                                        'orderby' => 'name',
                                        'order' => 'ASC'
                                    );
                                    $categories = get_categories($cat_args);
                                    $categoryNames = '';
                                    foreach($categories as $category) :
                                        if($category->term_id !== 1) {
                                            $categoryNames .= $category->name . ',';
                                        }
                                    endforeach;
                                    echo do_shortcode('[stc-subscribe category_in="'.rtrim($categoryNames, ',').'"]');
                                    ?>
                                    <div style="clear:both;"></div>
                                </div>
                                <div class="item copy-rss-feed">
                                    <h2>Copy RSS FEED URL</h2>
                                    <label for="copy_feed">Copy RSS Feed URL</label>
                                    <input type="text" name="copy_feed" class="copyToClipboard" readonly value="<?= site_url() ?>/feed" />
                                </div>
                                <div class="item all-blogs">
                                    <a href="<?= site_url(); ?>">View All Blogs</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="section-footer" aria-label="Section Footer" class="bg-iu-cream">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-9 col-pos-1">
                    <h4>IU School of Medicine | Office of Strategic Communications</h4>
                    <div class="contact-info">410 W. 10th Street | HITS 3080 | Indianapolis, IN 46202 | iusm@iu.edu</div>
                </div>
                <div class="col-xs-12 col-sm-3 col-pos-2">
                    <a class="button" href="mailto:iusm@iu.edu">CONTACT US</a>
                </div>
            </div>
        </div>
    </div>

<?php
get_footer();
