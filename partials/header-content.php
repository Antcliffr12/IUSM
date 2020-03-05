<?php
global $iusm_config, $extra_body_classes, $menu_tree, $fp_title, $fp_page_parents;

if (!isset($fp_title) || empty($fp_title))
    $title = get_the_title($id);
else
    $title = $fp_title;
if(is_search())
    $title = __('Search Results', 'codeless');
if(is_404())
    $title = __('404 Not Found', 'codeless');

$site_id = get_current_blog_id();


if(function_exists('codeless_page_parents')) {
    if (!isset($fp_page_parents) || empty($fp_page_parents))
        $page_parents = codeless_page_parents();
    else
        $page_parents = codeless_page_parents($fp_page_parents, true);
}


$hide_breadcrumb = isset($post) ? get_post_meta( $post->ID, 'hide_breadcrumb', true ) : '';
$kw_assigned_slider = isset($post) ? get_post_meta( $post->ID, 'kw_slide_page_assignment', true ) : '';

$bannerText = isset($post) ? get_post_meta( $post->ID, 'sb_section_level_banner', true ) : '';
$bannerTitleDisplay = isset($post) ? get_post_meta( $post->ID, 'sb_title_display', true ) : '';
$bannerBg = isset($post) ? get_post_meta( $post->ID, 'sb_section_level_bg_color', true ) : '';
$bannerImage = isset($post) ? get_post_meta($post->ID, 'meta-image', true) : '';
$bannerFontColor = isset($post) ? get_post_meta($post->ID, 'sb_section_level_font_color', true) : '';



// Settings for category.php Template
if(is_category()){
    $cat_id = get_queried_object_id();;
    $bannerText = get_cat_name($cat_id);
    $bannerImage = get_option("category_banner_image_$cat_id");
    $bannerFontColor = 'color-iu-crimson';
}

// Settings for single.php Template Only Default 'post' for blogs 
if(is_single() && $site_id == 23){
    $bannerText = $bannerTitleDisplay == 'post' ? get_the_category( $post->ID )[0]->name : $bannerText;
}

// Settings for Author.php Template
if(is_author()){
    try{
        $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
        $author_id = $author->ID;
        $fname = get_the_author_meta('first_name', $author_id);
        $lname = get_the_author_meta('last_name', $author_id);
        $dname = get_the_author_meta('display_name', $author_id);
        if(!empty($fname) && !empty($lname)){
            $bannerText =  $fname . ' ' . $lname;
        }else{
            $bannerText = $dname;
        }
    }catch(\Exception $e){
        $bannerText = '';
    }
}

if(is_search()){
    $bannerText = '';
}

?>


<?php if ($kw_assigned_slider && !is_search()) { ?>
    <div id="banner-slider">
        <?= do_shortcode('[kw-slick-slider slider="'. $kw_assigned_slider .'"]'); ?>
    </div>
<?php } ?>

<?php
    if($bannerText && !is_search()) {
    $background = (isset($bannerBg) && !empty($bannerBg)) ? 'class="'.$bannerBg.'"' : 'class="bg-iu-crimson"';
    $background = (isset($bannerImage) && !empty($bannerImage)) ? 'style="background-image:url('.$bannerImage.');background-repeat:no-repeat;" class="has-background-image"' : $background;
    $bannerFontColor = (isset($bannerFontColor) && !empty($bannerFontColor)) ? ' class="'.$bannerFontColor.'"' : '' ;
    ?>
    <div id="section-level-banner" <?= $background ?>>
        <div class="container">
            <h2<?= $bannerFontColor?>><?= $bannerText ?></h2>
        </div>
    </div>
<?php } ?>
<?php
if($site_id == 24 && $site_id != is_tag() && !is_404()){
  $background = (isset($bannerBg) && !empty($bannerBg)) ? 'class="'.$bannerBg.'"' : 'class="bg-iu-crimson"';

  ?>
  <div id="section-level-banner" <?= $background ?>>
    <div class="container">
      <h2>Newsroom</h2>
    </div>
</div>
  <?php
}
if(is_tag()){
  $background = (isset($bannerBg) && !empty($bannerBg)) ? 'class="'.$bannerBg.'"' : 'class="bg-iu-crimson"';
  ?>
  <div id="section-level-banner" <?= $background ?>>
    <div class="container">
      <?php
      $tag = get_queried_object();
      //      echo $tag->slug;
      ?>
      <h2><?= ucwords($tag->name); ?></h2>
    </div>
</div>
  <?php

}
// if(is_tag()){
//   $tag = get_queried_object();
//      echo $tag->slug;
// }
?>
<?php
 $blog_id = get_current_blog_id();
if ($site_id === 24 && is_page('home') ) :
echo render_component('news-menu');
echo get_alerts();
endif;
 ?>
<?php

if(is_multisite()) {
    /** Multisite */
    $siteId = get_current_blog_id();
    if ($siteId == '1') {
        if (!$hide_breadcrumb && !is_404() && !is_search() && !is_front_page() && !is_home() && !is_single() && !is_tag()) {
            ?>
            <section id="breadcrumbs">
                <div class="container">
                    <?= render_component('breadcrumbs', ['page_parents' => $page_parents, 'title' => $title]); ?>
                </div>
            </section>
            <?php
        }
    }else {

        if(isset(get_the_category()[0])){
            // show nothing
        }else if(!is_404() && !is_search() && is_front_page() && is_home() && !is_single() && !is_tag()){
            $landingPageTitle = get_bloginfo( 'name' );
            ?>
            <section id="breadcrumbs">
                <div class="container">
                    <?= render_component('breadcrumbs', ['page_parents' => $page_parents, 'title' => $landingPageTitle]); ?>
                </div>
            </section>
            <?php
        }else if (!$hide_breadcrumb && !is_404() && !is_search() && !is_single() && !is_tag()) {

            ?>
            <section id="breadcrumbs">
                <div class="container">
                    <?= render_component('breadcrumbs', ['page_parents' => $page_parents, 'title' => $title]); ?>
                </div>
            </section>
            <?php
        }
    }
} else {
    /** Not Multisite */
    if (!$hide_breadcrumb && !is_404() && !is_search() && !is_front_page() && !is_home() && !is_single() && !is_tag()) {
        ?>
        <div id="breadcrumbs">
            <div class="container">
                <?= render_component('breadcrumbs', ['page_parents' => $page_parents, 'title' => $title]); ?>
            </div>
        </div>
        <?php
    }
}
?>
