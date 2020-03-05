<?php
global $extra_body_classes;
$extra_body_classes = 'page-layout-full-width error404';
$errorImage = THEME_PATH . '/assets/images/404.jpg';
get_header();
get_template_part('partials/header-content');
?>

    <section class="iu-section-block error404" data-component="IU Section Block">
        <div class="l-fullwidth clearfix">
            <div class="item">
                <img src="<?= $errorImage ?>" alt="404: Page Not Found.">
                    <div class="overlay-box">
                        <h1>Not the results you were expecting. Sorry.</h1>
                        <p>Find information about the IU School of Medicine education programs, medical research and academic departments using the main navigation items.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php get_footer(); ?>
