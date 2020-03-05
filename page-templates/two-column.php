<?php
/*
Template Name: 2-Column (Left Sidebar)
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
    //$section_switcher = render_component('institutes-switcher', ['path' => $path]);
    $subnav_root_path = '/research/centers-institutes/' . $segments[2];
}
if (count($segments) > 1) {
    if ($segments[0] === 'departments') {
       // $section_switcher = render_component('department-switcher', ['path' => $path]);
        $subnav_root_path = '/departments/' . $segments[1];
    } elseif ($segments[0] === 'campuses') {
        //$section_switcher = render_component('campus-switcher', ['path' => $path]);
        $subnav_root_path = '/campuses/' . $segments[1];
    }
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
                        <ul class="menu" data-menudepth="0">

                        <?php
                        if (!is_null(DEFAULT_SIDEBAR_MENU_ID) && !empty(DEFAULT_SIDEBAR_MENU_ID)) {
                            wp_nav_menu(array(
                                'menu' => DEFAULT_SIDEBAR_MENU_ID,
                                'container' => false,
                                'items_wrap' => '%3$s',
                                'walker' => new WalkerNavSidebar(),
                                'sub_menu' => true,
                                'subnav_root_path' => $subnav_root_path,
                            ));
                        }
                        ?>
                        </ul>
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
