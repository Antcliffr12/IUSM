<?php
/*
Template Name: Default (Full-width)
*/
global $menu_tree;
// $menu_tree = new MenuTree('main');

global $extra_body_classes;
$extra_body_classes = 'page-layout-full-width';
get_header();
get_template_part('partials/header-content');
?>

<section id="content">

	<div id="region-main">
		<?php the_post() ?>
		<?php the_content() ?>
	
	</div>

</section>

<?php get_footer(); ?>
