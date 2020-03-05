<?php
/**
 * Some functionality ported from the Codeless theme base
 */

if(!defined('CODELESS_BASE')) define('CODELESS_BASE', get_template_directory().'/');

if(!defined('CODELESS_BASE_URL' ) ) define( 'CODELESS_BASE_URL', THEME_PATH.'/');

if(function_exists('wp_get_theme'))
{
	$wp_theme_obj = wp_get_theme();
	$codeless_base_data['prefix'] = $codeless_base_data['Title'] = $wp_theme_obj->get('Name');
	if(!defined('THEMENAME')) define('THEMENAME', $codeless_base_data['Title']);
}

if(!defined('THEMETITLE')) define('THEMETITLE', $codeless_base_data['Title']);

if(!function_exists('codeless_get_post_id')){
	/**
	 * codeless_get_post_id()
	 *
	 * @return
	 */
	function codeless_get_post_id()
	{
		global $codeless_config, $cl_current_view, $cl_redata, $for_online;
		$ID = false;

		if(!isset($codeless_config['real_ID']))
		{
			if(!empty($codeless_config['new_query']['page_id']))
			{
				$ID = $codeless_config['new_query']['page_id'];
			}
			else
			{
				$ID = @get_the_ID();
			}

			$codeless_config['real_ID'] = $ID;
		}
		else
		{
			$ID = $codeless_config['real_ID'];
		}

		if(class_exists('woocommerce') && is_shop()){
			$ID = get_option('woocommerce_shop_page_id');
		}

		if(isset($cl_current_view) && $cl_current_view == 'blog' && !isset($for_online) )
			$ID = $cl_redata['blogpage'];

		return $ID;
	}

	add_action('wp_head', 'codeless_get_post_id');
}


/*--------------------- HTML 5 VIDEO ---------------------------------------- */

if(!function_exists('codeless_html5_video_embed'))
{
	function codeless_html5_video_embed($path, $image = "", $types = array('webm' => 'type="video/webm"', 'mp4' => 'type="video/mp4"', 'ogv' => 'type="video/ogg"'))
	{
		preg_match("!^(.+?)(?:\.([^.]+))?$!", $path, $path_split);

		$output = "";
		if(isset($path_split[1]))
		{
			if(!$image && @file_get_contents($path_split[1].'.jpg',0,NULL,0,1))
			{
				$image = 'poster="'.$path_split[1].'.jpg"';
			}

			$uid = 'player_'.get_the_ID().'_'.mt_rand().'_'.mt_rand();

			$output .= '<video class="codeless_video" '.$image.' controls id="'.$uid.'">';

			foreach ($types as $key => $type)
			{
				if($path_split[2] == $key || @file_get_contents($path_split[1].'.'.$key,0,NULL,0,1))
				{
					$output .= '	<source src="'.$path_split[1].'.'.$key.'" '.$type.' />';
				}
			}

			$output .= '</video>';
		}
		return $output;
	}
}

/*--------------------- END HTML 5 VIDEO --------------------------------- */

/**
 * Gets an array of the current pages ancestors.
 *
 * @param object $target_post An optional post object for which the ancestor chain will be evaluated
 * @uses object $post
 * @return int
 */
function codeless_page_parents($target_post = null, $add_target_to_chain = false) {
	global $post, $wp_query, $wpdb;

	if((int) codeless_get_post_id() != 0){
		$post = $wp_query->post;

		if (!isset($target_post)) {
			$target_post = $post;
		}

		$parent_array = array();
		$current_page = $target_post->ID;
		$parent = 1;
		while($parent) {
			$sql = $wpdb->prepare("SELECT ID, post_parent FROM $wpdb->posts WHERE ID = %d; ", array($current_page) );
			$page_query = $wpdb->get_row($sql);
			$parent = $current_page = $page_query->post_parent;
			if($parent)
				$parent_array[] = $page_query->post_parent;
		}

		if ($add_target_to_chain) {
			array_unshift($parent_array, $target_post->ID);
		}

		return $parent_array;
	}
}


if (!function_exists('get_post_top_ancestor_id')) {
	/**
	 * Gets the id of the topmost ancestor of the current page. Returns the current
	 * page's id if there is no parent.
	 *
	 * @param object $target_post An optional post object for which the ancestor chain will be evaluated
	 * @uses object $post
	 * @return int
	 */
	function get_post_top_ancestor_id($target_post) {
		global $post;

		if (!isset($target_post)) {
			$target_post = $post;
		}

		if ($target_post->post_parent) {
			$ancestors = array_reverse(get_post_ancestors($target_post->ID));
			return $ancestors[0];
		}

		return $target_post->ID;
	}

}
