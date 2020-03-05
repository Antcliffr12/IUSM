<?php

/*
Template Name: News Search Main Page
@package WordPress
@subpackage IUSM
 */

get_header();
get_template_part('partials/header-content');
echo render_component('news-menu');
echo render_component('news-search');
/*echo render_component('authors-all-advising', ['bg_color' => 'bg-iu-cream', 'heading' => 'All Academic Advising Blog Authors']);*/
get_footer();
