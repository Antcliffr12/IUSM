<?php
/*
Template Name: 2-Column Departments (Left Sidebar)
*/
$path = get_page_uri($post->ID);
global $current_path;

$current_path = WP_SITEURL . '/' . trim($path, '/') . '/';
$segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));

$subnav_root_path = '/'. (count($segments) > 0 ? $segments[1] : ''); // Default to second-level page as menu root
//1 on local 0 on DEV and LIVE

// if (count($segments) > 2) {
// 	if ($segments[1] === 'departments') {
// 	 $section_switcher = render_component('department-switcher', ['path' => $path]);
// 	 $subnav_root_path = '/departments/' . $segments[2];
//  } elseif ($segments[1] === 'campuses') {
// 		$section_switcher = render_component('campus-switcher', ['path' => $path]);
// 		$subnav_root_path = '/campuses/' . $segments[2];
// 	}
// } else if (count($segments) > 3 && $segments[1] === 'research' && $segments[2] === 'centers-institutes' ) {
// 	echo $subnav_root_path;
// 	$section_switcher = render_component('institutes-switcher', ['path' => $path]);
// 	$subnav_root_path = '/research/centers-institutes/' . $segments[3];
// }
if (count($segments) > 2 && $segments[0] === 'research' && $segments[1] === 'centers-institutes') {
		$section_switcher = render_component('institutes-switcher', ['path' => $path]);
		$subnav_root_path = '/research/centers-institutes/' . $segments[2];
}
if (count($segments) > 1) {
	if ($segments[0] === 'departments') {
	 $section_switcher = render_component('department-switcher', ['path' => $path]);
	 $subnav_root_path = '/departments/' . $segments[1];
 } elseif ($segments[0] === 'campuses') {
		$section_switcher = render_component('campus-switcher', ['path' => $path]);
		$subnav_root_path = '/campuses/' . $segments[1];
	}
}


if (!isset($_GET['hidenav'])) {
global $menu_tree;
$menu_tree = new MenuTree('main');
}
global $extra_body_classes;
$extra_body_classes = 'page-layout-two-column';
get_header();
get_template_part('partials/header-content');
?>

<section id="content">
	<div class="container">
		<div class="row">

			<div id="region-aux1" class="col-xs-12 col-md-3">
				<?= isset($section_switcher) ? $section_switcher : ''; ?>
				<div id="sidebar-nav" class="collapse-mobile" data-current="<?= $current_path; ?>">
					<h2 class="menu-toggle desktop-hide">In This Section:</h2>
					<nav role="navigation" aria-label="Sidebar Navigation" class="menu-wrapper">
				<?php

				$locations = get_nav_menu_locations();
				if ( isset( $locations['main']) ) {
						 $menu = get_term( $locations['main'], 'nav_menu');
						 $depth = 0;
						 $submenu = false;
						 $markup = "";

						 if ( $items = wp_get_nav_menu_items( $menu->name ) ) {
							 $classes = [];

							 if($depth === 0){
								 $classes[] = 'menu';
							 }else{
								 $classes[] = 'sub-menu';
							 }

							 $menu_item_parents = array();
							 $markup .= '<ul class="' .implode('', $classes).'" data-menudepth="'.$depth.'">'.PHP_EOL;
							 foreach($items as $key => $item){

								 //print_r($items);
								 //if current item is not a top level item skip
							 if ( !$item->menu_item_parent ):
								 //get ID of current menu item
								$parent_id = $item->ID;

								 // echo $current_nav;
								 //adds menu-item to classes array
								 $item->classes[] = 'menu-item';
								 //gets current page
								 $link = get_permalink(get_the_ID());

								  $page_title = $wp_query->post->post_title;
									 //current page add class
								 if ($link == $item->url) {
										$item->classes[] = 'current-menu-item';
								 } else if (stripos($link, $item->url) === 0) {
										$item->classes[] = 'current-menu-ancestor';
								 }
								 $depth += 1;
								 //class for item
								 $markup .= '<li class="' . trim(implode(' ', $item->classes)) . '" data-itemid="'. $parent_id .'">';
								 $markup .= '<a rel="page" href="'. $item->url .'">'. $item->title .'</a>';
							 		endif;
									//get child pages
								 if ( $parent_id == $item->menu_item_parent ){
										 $markup .= '<ul class="sub-menu" data-menudepth="'.$depth.'">'.PHP_EOL;
										 $markup .= '<li class="' . trim(implode(' ', $item->classes)) . '" data-itemid="'. $parent_id .'">';

									 	 $markup .= '<a rel="page" href="'. $item->url .'">'. $item->title .'</a>';

									 $markup .= '</ul>';
								 }

							 }//end foreach
							  $markup .= '</li>'.PHP_EOL;
						 }
							 $markup .= '</ul>'.PHP_EOL;
							 echo $markup;

					 }


				 ?>
			 </nav>
			</div>
			</div>

			<div id="region-main" class="col-xs-12 col-md-9">

				<?php
				the_post();
				the_content();
				?>

			</div>

		</div>
	</div>
</section>

<?php get_footer(); ?>
