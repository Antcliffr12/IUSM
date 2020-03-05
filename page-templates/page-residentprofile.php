<?php
/*
Template Name: Resident Profile
*/
define('LOCATION_VIRTUAL', true);

// Load Faculty Data API
require_once('ResidentData.php');

global $parent, $menu_tree, $title, $fp_title, $fp_page_parents, $mysection, $mysectionpath;
$hide_sidebar = false;
$path = trim($_SERVER['REQUEST_URI']);
$segments = explode('/', trim($path, '/'));
// $menu_tree = new MenuTree('main');


global $extra_body_classes;
$extra_body_classes = 'page-layout-two-column page-faculty-profile';

// Determine profile ID from URL
$resident_id = filter_var(get_query_var('resident_id'), FILTER_SANITIZE_NUMBER_INT);


// Determine current section from URL
$section = filter_var(get_query_var('section'), FILTER_SANITIZE_STRING);

// Set section to global variable
$mysection = $section;
echo $mysection;
if (count($segments) == 3 && $segments[0] == 'resident' && is_numeric($segments[1])) {
	$hide_sidebar = true;
}

$title = get_the_title($id);
if(is_search())
	$title = __('Search Results', 'codeless');
if(is_404())
	$title = __('404 Not Found', 'codeless');
$page_parents = codeless_page_parents($parent, true);

// Instantiate a ResidentData object for the specified person
$profile = new IU\ResidentData($resident_id);
// Display Name
$fullname = $profile->first_name.(isset($profile->middle_name)? ' '.substr($profile->middle_name, 0, 1).'.' :'').' '.$profile->last_name;
$title = $fullname.(count($profile->degrees) > 0 ? ', '.$profile->degrees[0] : '');
define('OVERRIDE_TITLE', $title);

$fp_title = $title;
$fp_page_parents = $parent;
$iu_health = $profile->iu_health;
$dept_code = $profile->dept_code;
//
// if ($dept_code == 'IN-NEUR') {
// 	$mysectionpath = '/departments/neurology/faculty/';
// }
// else if ($dept_code == 'IN-OTHN') {
// 	$mysectionpath = '/departments/otolaryngology/faculty/';
// }
// else if ($dept_code == 'IN-PHMR') {
// 	$mysectionpath = '/departments/physiatry/faculty/';
// }
// else if ($dept_code == 'IN-SNEU') {
// 	$mysectionpath = '/departments/neurological-surgery/faculty/';
// }
// else {
// 	$mysectionpath = '/departments/';
// }

get_header();
get_template_part('partials/header-content');
?>
<section id="content">
	<div class="container">
		<div class="row">

			<?php if(!$hide_sidebar):?>
			<div id="region-aux1" class="col-xs-12 col-md-3">

				<?= isset($section_switcher) ? $section_switcher : ''; ?>

				<!-- render_component('sidebar-nav', ['items' => $menu_tree->setScope($subnav_root_path)->setMaxDepth(4)->render(['skip_root' => true]),]);  -->

				<div id="sidebar-nav" class="collapse-mobile" data-current="<?= $current_path; ?>">
					<h2 class="menu-toggle desktop-hide">In This Section:</h2>
					<nav role="navigation" aria-label="Sidebar Navigation" class="menu-wrapper">
						<ul class="menu" data-menudepth="0">
								 <?php

					          	$segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));

									$subnav_root_path = '/'. (count($segments) > 0 ? $segments[0] : ''); // Default to second-level page as menu root
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
			<?php endif;?>

			<div id="region-main" class="col-xs-12 <?=($hide_sidebar)? 'col-md-12' : 'col-md-9'?>">
				<?= render_component('resident-profile', [
					'profile' => $profile,
					'fullname' => $fullname,
					'title' => $title,
				]); ?>

				<section class="iu-section-block bg-white padding-normal padding-condensed-top">

                      <?php if(isset($profile->iu_health)): ?>
					<div class="container">
						<aside class="iu-callout-box callout-normal bg-iu-cream" data-component="Callout Box">
							<h3>Looking for patient care?</h3>
							<?php if($profile->dept_code == 'IN-OTHN'): ?>
							<div class="body">
								<p>To schedule an appointment with an Otolaryngology physician, call 317-278-1212.</p>
							</div>
							<div class="button-row">
								<a class="button" data-style="default" href="http://iuhealth.org/find-a-doctor/" target="_blank">FIND A DOCTOR</a>
							</div>
                            <?php endif;?>
                            <?php if($profile->dept_code != 'IN-OTHN'): ?>
							<div class="body">
								<p>To schedule an appointment with a faculty member physician of IU School of Medicine, contact Indiana University Health at 888-484-3258 or use the physician finder by clicking the button below.</p>
							</div>
                            <div class="button-row">
								<a class="button" data-style="default" href="http://iuhealth.org/find-a-doctor/" target="_blank">FIND A DOCTOR</a>
							</div>
           	                <?php endif;?>
						</aside>
					</div>
	                <?php else: ?>
                    <?php if(is_null($profile->leader)): ?>
                    <div class="container">
						<aside class="iu-callout-box callout-normal bg-iu-cream" data-component="Callout Box">
							<h3 style="color:#990000;">Apply for Residency</h3>
							<div class="body">
								<p>Faculty research at IU School of Medicine is transforming health. Details about the medical research being conducted in faculty labs throughout IU School of Medicine are available in the Research section of this site.</p>
							</div>
							<div class="button-row">
								<a class="button" data-style="default" href="/education/gme/residency-programs/application-requirements/">Residency Admissions</a>
							</div>
						</aside>
					</div>
	                <?php endif; ?>
	                <?php endif; ?>
               </section>

			</div>

		</div>
	</div>
</section>

<?php get_footer(); ?>
