<?php
/**
 * Template Name:Innovate
 */
 get_header();
 get_template_part('partials/header-content');

 $default_text = get_stylesheet_directory_uri() . '/assets/images/innovate-logo.svg';
 $default_image = get_stylesheet_directory_uri() . '/assets/images/IUSM-Innovation-BG-Image.png';
 ?>
<div style="background-image: url(<?php echo $default_image ?>); background-size: cover; background-position: center center;">
  <div class="container add-flex BodyContainer">
            <div class="innovate-content add-flex">
                <div class="innovate-title">
                    <img src="<?= $default_text ?>" />
                </div>
                <div class="innovate-paragraph">
                    <p>What if you could redesign medical education from scratch? What if we set aside what we know about how students have been taught, and spent more time thinking about how they should be taught? What would it look like?</p>
                </div>
                <div class="innovate-buttons add-flex">
                    <a class="button" href="<?= site_url() ?>/new-idea">SUBMIT A NEW IDEA</a>
                    <a class="button" href="#">REVIEW EXISTING IDEAS</a>
                </div>
            </div>
        </div>

           </div>

 <?php
 get_footer();

  ?>
