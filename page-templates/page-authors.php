<?php

/*
Template Name: Authors Main Page
@package WordPress
@subpackage IUSM
 */

get_header();
get_template_part('partials/header-content');
echo render_component('blog-menu');
echo render_component('authors-search');
echo render_component('authors-featured');
/*echo render_component('authors-all-advising', ['bg_color' => 'bg-iu-cream', 'heading' => 'All Academic Advising Blog Authors']);*/
get_footer();

