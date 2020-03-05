<?php

/**
 * Registers custom query vars used
 * @param $query_vars
 * @return array
 */
function iusm_query_vars( $query_vars ){
	$query_vars[] = 'section';
	$query_vars[] = 'faculty_id';
	$query_vars[] = 'resident_id';
	return $query_vars;
}
add_filter( 'query_vars', 'iusm_query_vars' );

/**
 * Defines custom route handling rules
 */
function iusm_rewrites_init(){

	// Orphan faculty profile (no department context)
	add_rewrite_rule(
		'^faculty/([0-9]+)(/[-a-z]+/?)?$',
		'index.php?pagename=facultyprofile&faculty_id=$matches[1]',
		'top'
	);

    add_rewrite_rule(
        '^campuses/(.+)/faculty/([0-9]+)(/[-a-z]+/?)?$',
        'index.php?pagename=facultyprofile&section=$matches[1]&faculty_id=$matches[2]',
        'top'
    );

	// Department faculty profile (section determined by URI)
	add_rewrite_rule(
		'^departments/(.+)/faculty/([0-9]+)(/[-a-z]+/?)?$',
		'index.php?pagename=facultyprofile&section=$matches[1]&faculty_id=$matches[2]',
		'top'
	);

	// Department Resident profile (section determined by URI)
	add_rewrite_rule(
		'^departments/(.+)/resident/([0-9]+)(/[-a-z]+/?)?$',
		'index.php?pagename=residentprofile&section=$matches[1]&resident_id=$matches[2]',
		'top'
	);

	//resident
	add_rewrite_rule(
		'^resident/([0-9]+)(/[-a-z]+/?)?$',
		'index.php?pagename=residentprofile&resident_id=$matches[1]',
		'top'
	);


}
add_action( 'init', 'iusm_rewrites_init' );


function iusm_page_link_filter($link, $post_id = null, $sample = null) {
	$path = trim($_SERVER['REQUEST_URI']);


	if (preg_match('@facultyprofile/@', $link)) {
		$link = WP_SITEURL . $path;
	}

	if (preg_match('@residentprofile/@', $link)) {
		$link = WP_SITEURL . $path;
	}

	return $link;
}
add_filter('page_link', 'iusm_page_link_filter');
