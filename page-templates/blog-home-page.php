<?php
/*
Template Name: Blog Home Page
*/
get_header();

echo render_component('iu-blog-post-grid', ['title' => get_the_title()]);

get_footer();
