<?php
define('THEME_PATH', get_stylesheet_directory_uri());
define('DEFAULT_AUTHOR_PROFILE_IMG', THEME_PATH . '/assets/images/default_avatar.png');
define('DEFAULT_SIDEBAR_MENU_ID', 'main');

// Initialize theme config array
global $iusm_config;
if (is_null($iusm_config)) {
	$iusm_config = [];
}

// need to add jquery date picker for event calendar
function iusm_enqueue_datepicker() {
    // Load the datepicker script (pre-registered in WordPress).
    wp_enqueue_script( 'jquery-ui-datepicker' );
    // You need styling for the datepicker. For simplicity I've linked to Google's hosted jQuery UI CSS.
    wp_register_style( 'jquery-ui', THEME_PATH . '/assets/styles/jquery-ui.css' );
    wp_enqueue_style( 'jquery-ui' );
}
add_action( 'wp_enqueue_scripts', 'iusm_enqueue_datepicker' );
// add for style css file
//function iusm_event_styles(){
//  wp_enqueue_style( 'iusm-theme-event-styles', THEME_PATH . '/assets/styles/events-style.less' );
//}
//add_filter('wp_enqueue_scripts', 'iusm_event_styles');
/**
 * Render method for lightweight UI components
 *
 * @param $component_name - The folder name of the component
 * @param array $context - A set of context variables to expose to the component's template
 * @return string - The rendered component markup
 */
function render_component($component_name, $params = array()) {
	$context = get_queried_object();
	try {
		if (!isset($component_name)) {
			throw new \Exception("Component not specified!");
		}
		$name_parts = explode(':', $component_name);
		$component_name = array_shift($name_parts);
		$variant_name = (count($name_parts) > 0) ? '.'.array_shift($name_parts) : '';
		$component_file = TEMPLATEPATH .'/assets/components/'.$component_name.'/' . $component_name . $variant_name . '.view.php';
		if (isset($params['mock'])) {
			$component_file = TEMPLATEPATH .'/assets/components/'.$component_name.'/' . $component_name . '.view.mock.' . $params['mock'] . '.php';
		}
		if (!file_exists($component_file)) {
			throw new \Exception("Component {$component_name} not found at '{$component_file}'!");
		}
		extract($params, EXTR_SKIP);
		ob_start();
		include $component_file;
		return ob_get_clean();
	} catch (Exception $ex) {
		return $ex->getMessage();
	}
}
function iusm_register_admin_assets() {
	wp_enqueue_style( 'iusm-theme-admin-backend-styles', THEME_PATH . '/assets/bundles/styles-admin.css' );
}
add_filter('vc_backend_editor_enqueue_js_css', 'iusm_register_admin_assets');


// Loop through and process base theme includes
foreach( glob(TEMPLATEPATH .'/theme/*/*.php') as $filename){
	include_once $filename ;
}

// Include all shortcodes/Visual Composer additions provided by components
foreach( glob(TEMPLATEPATH .'/assets/components/*/*.vcplugin.php') as $filename){
	require_once $filename;
}
function iusm_tinymce_buttons($buttons) {
	// Remove specific buttons from WYSIWYG editor
	$remove = array('charmap');
	return array_diff($buttons,$remove);
}
add_filter('mce_buttons_2','iusm_tinymce_buttons');
// Given a serialized value representing a Visual Composer multiple-field group,
// attempt to return only items which are properly populated
function iusm_get_valid_items($serialized_items, $filter_field) {
	$items = array();
	if ($serialized_items != '') {
		$unprocessed = vc_param_group_parse_atts($serialized_items);
		foreach($unprocessed as $row) {
			if (!empty($row[$filter_field])) {
				$items[] = $row;
			}
		}
	}
	return $items;
}
// REMOVE VC SHORTCODES LIST
$vc_remove_shortcode_list = [
	'vc_btn',
	'vc_cta',
	'vc_custom_heading',
	'vc_empty_space',
	'vc_flickr',
	'vc_gallery',
	'vc_icon',
	'vc_images_carousel',
	'vc_line_chart',
	'vc_message',
	'vc_pie',
	'vc_posts_slider',
	'vc_progress_bar',
	'vc_round_chart',
	'vc_separator',
	'vc_text_separator',
	'vc_basic_grid',
	'vc_masonry_grid',
	'vc_masonry_media_grid',
	'vc_media_grid',
	'vc_facebook',
    'vc_googleplus',
	'vc_pinterest',
	'vc_tweetmeme',
	'vc_raw_html',
	'vc_raw_js',
	'vc_widget_sidebar',
	'vc_tabs',
	'vc_tour',
	'vc_accordion',
	'vc_tta_pageable',
	'vc_tta_tabs',
	'vc_tta_tour',
	'vc_message_box',
];
if( function_exists('vc_remove_element')) {
	foreach ($vc_remove_shortcode_list as $shortCode) {
		vc_remove_element($shortCode);
	}
}
function StripPhoneNumber($number){
    return preg_replace('/\D+/', '', $number);
}
function LimitText($text, $limit){
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = rtrim(substr($text, 0, $pos[$limit])) . '...';
    }
    return $text;
}
// USED PRIMARILY FOR FINDING SLICK SLIDER CATEGORIES
function get_list_of_term_names($taxonomy){
    global $wpdb;
    $query = "SELECT term.name FROM $wpdb->term_taxonomy as taxonomy
              LEFT JOIN $wpdb->terms as term ON term.term_id=taxonomy.term_id
              WHERE taxonomy.taxonomy = %s";
    $results = $wpdb->get_results($wpdb->prepare($query, sanitize_text_field($taxonomy)));
    $returnArray = [];
    foreach($results as $result){
        $returnArray[$result->name] = $result->name;
    }
    return $returnArray;
}
function remove_revolution_slider_meta_boxes()
{
    // Remove the rev_slider metabox for kw_slick_slider custom post type. Just for cleanup.
    if (is_admin()) {
        global $post;
        if ($post) {
            if ($post->post_type == 'kw_slick_slider') {
                remove_meta_box('mymetabox_revslider_0', 'kw_slick_slider', 'normal');
            }
        }
    }
}
add_action('do_meta_boxes', 'remove_revolution_slider_meta_boxes');
/**
 * update kw_slick_slider
*/
add_action( 'init', 'exclude_from_search', 99 );
function exclude_from_search()
{
	global $wp_post_types;
	if (post_type_exists('kw_slick_slider')) {
		// exclude from search results
		$wp_post_types['kw_slick_slider']->exclude_from_search = true;
	}
}
/* Limit excerpts and content for various locations such as blog main page, feeds, etc */
function limit_excerpt($limit) {
    $limit_excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($limit_excerpt)>=$limit) {
        array_pop($limit_excerpt);
        $limit_excerpt = implode('  ',$limit_excerpt).'...';
    } else {
        $limit_excerpt = implode(' ',$limit_excerpt);
    }
    $limit_excerpt = preg_replace('`[[^]]*]`','',$limit_excerpt);
    return $limit_excerpt;
}
function limit_content($limit, $content) {
    if(!empty($content) && !is_null($content)):
    $limit_content = explode(' ', $content, $limit);
        if (count($limit_content)>=$limit) {
            array_pop($limit_content);
            $limit_content = implode('  ',$limit_content).'...';
        } else {
            $limit_content = implode(' ',$limit_content);
        }
         $formattedContent = preg_replace('`[[^]]*]`','',$limit_content);
        return trim(strip_tags($formattedContent));
    else:
        return '';
    endif;
}
add_filter( 'category_rewrite_rules', 'vipx_filter_category_rewrite_rules' );
function vipx_filter_category_rewrite_rules( $rules ) {
    $categories = get_categories( array( 'hide_empty' => false ) );
    if ( is_array( $categories ) && ! empty( $categories ) ) {
        $slugs = array();
        foreach ( $categories as $category ) {
            if ( is_object( $category ) && ! is_wp_error( $category ) ) {
                if ( 0 == $category->category_parent ) {
                    $slugs[] = $category->slug;
                } else {
                    $slugs[] = trim( get_category_parents( $category->term_id, false, '/', true ), '/' );
                }
            }
        }
        if ( ! empty( $slugs ) ) {
            $rules = array();
            foreach ( $slugs as $slug ) {
                $rules[ '(' . $slug . ')/feed/(feed|rdf|rss|rss2|atom)?/?$' ] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
                $rules[ '(' . $slug . ')/(feed|rdf|rss|rss2|atom)/?$' ] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
                $rules[ '(' . $slug . ')(/page/(\d+)/?)?$' ] = 'index.php?category_name=$matches[1]&paged=$matches[3]';
            }
        }
    }
    return $rules;
}
function remove_menus(){
    if (!current_user_can('administrator')) {
        remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
        remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=category');
    }
}
add_action('admin_menu', 'remove_menus');
/**
 * Return the capability that users need to view the Yoast SEO settings pages.
 *
 * @return mixed|void
 */
function my_custom_wpseo_manage_options_capability() {
    $manage_options_cap = 'edit_others_posts';
    return $manage_options_cap;
}
add_filter( 'wpseo_manage_options_capability', 'my_custom_wpseo_manage_options_capability' );
/**
 * Filter for USER Search of first letter of Last Name
 * REF:: http://wordpress.stackexchange.com/questions/198666/wp-user-query-get-all-authors-with-last-name-starting-with-specific-letter
 */
function wt_custom_meta_sql( $sql ) {
    /*
        Search for that funky so called unique identifier
        that we used to initialize our `WP_User_Query' object
    */
    $uid = '########';
    preg_match( "/'(%[^']+{$uid}%)'/", $sql['where'], $matches );
    if ( ! empty( $matches ) ) {
        /*
            We've found it and now we get rid of the
            extra '%' character as well as our identifier
        */
        $val = str_replace( "{$uid}%", "%", ltrim( $matches[1], '%' ) );
        $sql['where'] = str_replace( $matches[0], "'{$val}'", $sql['where'] );
    }
    return $sql;
}
add_filter( 'get_meta_sql' , 'wt_custom_meta_sql', 40 );
function getFacultyImage($fid) {
    $timeStamp = mktime(1, 0, 0);
    $cached_file = "wp-content/faculty-image-cache/{$fid}-{$timeStamp}.jpg";
    if (is_file($cached_file))
        return "/" . $cached_file;
    return "/faculty-image.php?fid=" . $fid;
}

add_filter( 'w3tc_can_print_comment', '__return_false', 10, 1 );


//http://matthewman.net/2012/10/09/wordpress-rss-custom-elements/
// add the namespace to the RSS opening element
function add_media_namespace() {
    echo 'xmlns:media="http://search.yahoo.com/mrss/"';
}

// add the requisite tag where a thumbnail exists
function add_media_thumbnail() {
    global $post;
    if( has_post_thumbnail( $post->ID )) {
        $thumb_ID = get_post_thumbnail_id( $post->ID );
        $details = wp_get_attachment_image_src($thumb_ID, 'iu-large');
        if( is_array($details) ) {
            echo '<media:thumbnail url="' . $details[0]
                . '" width="' . $details[1]
                . '" height="' . $details[2] . '" />';
        }
    }else{
        $defaultImage = THEME_PATH . '/assets/images/IUSM-Home-Blog-Placeholder.gif';
        echo '<media:thumbnail url="'.$defaultImage.'" />';
    }
}
// add the two functions above into the relevant WP hooks
add_action( 'rss2_ns', 'add_media_namespace' );
add_action( 'rss2_item', 'add_media_thumbnail' );



// Remove Edit with Visual Composer from admin bar
//https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=2031624

function vc_remove_wp_admin_bar_button() {
    remove_action( 'admin_bar_menu', array( vc_frontend_editor(), 'adminBarEditLink' ), 1000 );
}
add_action( 'vc_after_init', 'vc_remove_wp_admin_bar_button' );


// Enabled Widgets
function iusm_theme_widgets_init(){
    register_sidebar([
        'name' => 'Blog Post Social Share',
        'id' => 'blog_post_social_share',
        'before_widget' => '<div class="addthis_toolbox">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ]);
}
add_action('widgets_init', 'iusm_theme_widgets_init');




// Prevent the showing of posts with empty content filter.
function remove_posts_where_content_is_empty($where = ''){
    $where .= " AND trim(coalesce(post_content, '')) <>''";
    return $where;
}


// Flush Rewrite Rules when user creates or edits blog category. Fixes issue with pagination.
add_action('create_category', 'category_create_and_update_rewrite', 10, 2);
add_action('edit_category', 'category_create_and_update_rewrite', 10, 2);
function category_create_and_update_rewrite($term_id, $taxonomy_term_id){
    flush_rewrite_rules();
}


// ADMIN NOTICES, displays two custom messages to users.

//calls action for notices
add_action( 'admin_notices', 'new_post_admin_notice' );

//created function
  function new_post_admin_notice() {
		global $pagenow;
		//get users screen
		$screen = get_current_screen();
		//gets wordpress multisite id
		$site_id = get_current_blog_id();

		if($site_id === 23){
		if($pagenow =='post.php' || $pagenow == 'post-new.php'){
		//if user is on edit and it is a post
		if($screen->id  == 'post'){
			//div class for notice
			?>

     <div class="notice notice-info is-dismissible">
        <p><?php _e( 'Thanks for contributing to the IU School of Medicine blogs hub. As you draft content for this platform, please avoid violating HIPAA and other regulations. Review <a href="https://mednet.iu.edu/_layouts/15/WopiFrame.aspx?sourcedoc=/MasterDocLibrary/Communications-IUSM-BlogsHub-BloggerGuidelines.pdf&action=default" target="_blank">Blogger Guidelines</a> and <a href="https://mednet.iu.edu/MasterDocLibrary/HIPAA-Web-Compliance.pdf#search=HIPAA%2DWeb%2DCompliance" target="_blank">HIPAA considerations</a>.', 'sample-text-domain' ); ?></p>
    </div>

				<?php
				if(isset($_GET['message'])){
					?>
					<script>
					  			jQuery(".notice-info").hide();
					</script>
					<?php
				}
			} //if on post screen
		}//pagenow
	}//multisite id
}//function

function confirm(){

$messages = array(
					'default'   => 'Thanks for submitting! Before you publish your post, please make sure it doesn’t include any patient identifying information that violates HIPAA privacy laws. When in doubt, remove any information that may identify a patient. If it is important to a story to include patient information, use composites or change all the details or identifiers and inform readers that the information is a composite or has been changed to protect their patient’s privacy. Review Blogger Guidelines and HIPAA considerations.',
			);
			//get users screen
			$screen = get_current_screen();
			//gets wordpress multisite id
			$site_id = get_current_blog_id();

			if($site_id === 23){
				if($screen->id  == 'post'){
echo '<script type="text/javascript">
	jQuery(document).ready(function($){
		var message = "'.$messages['default'].'";
		var publish = document.getElementById("publish");
		if(publish !== null) publish.onclick = function(){
			return confirm(message);
		};
	});

</script>';
		}
	}
}
add_action('admin_footer', 'confirm');




function multisite_no_self_ping( &$links ) {
    $sites     = get_sites();
    $site_urls = array();
    foreach ( $sites as $site ) {
        $site_urls[] = get_home_url( $site->blog_id );
    }
    foreach ( $links as $key => $link ) {
        foreach ( $site_urls as $site_url ) {
            if ( 0 === strpos( $link, $site_url ) ) {
                unset( $links[ $key ] );
            }
        }
    }
}
add_action( 'pre_ping', 'multisite_no_self_ping' );



function get_alerts(){
  $is_alert = get_option( 'alert_checked' );
  $text = get_option('alert_text');
  $text_less = substr($text,0, -5). "...";

  if($is_alert == '1'){
    ?>
    <div class="notifcation-bar">
      <div class="container">
        <div class="flex">
          <div class="alert_text">
          <h3><?= get_option('alert_title'); ?></h3>
            <h4 class="text">
              <span><?= $text_less ?></span>
            </h4>
          </div>

            <p>
              <a href="<?= get_option('alert_url') ?>" />
                Read More
              </a>

        </div>
      </div>
    </div>
    <?php
  }
}





add_action( 'add_attachment', 'my_set_image_meta_upon_image_upload' );
function my_set_image_meta_upon_image_upload( $post_ID ) {

	// Check if uploaded file is an image, else do nothing

	if ( wp_attachment_is_image( $post_ID ) ) {

		$my_image_title = get_post( $post_ID )->post_title;

		// Sanitize the title:  remove hyphens, underscores & extra spaces:
		$my_image_title = preg_replace( '%\s*[-_\s]+\s*%', ' ',  $my_image_title );

		// Sanitize the title:  capitalize first letter of every word (other letters lower case):
		$my_image_title = ucwords( strtolower( $my_image_title ) );

		// Create an array with the image meta (Title, Caption, Description) to be updated
		// Note:  comment out the Excerpt/Caption or Content/Description lines if not needed
		$my_image_meta = array(
			'ID'		=> $post_ID,			// Specify the image (ID) to be updated
			'post_title'	=> $my_image_title,		// Set image Title to sanitized title
	
		);
		$withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $my_image_title);

		// Set the image Alt-Text
		update_post_meta( $post_ID, '_wp_attachment_image_alt', $withoutExt );

		// Set the image meta (e.g. Title, Excerpt, Content)
		wp_update_post( $my_image_meta );

	} 
}
add_filter('use_block_editor_for_post', '__return_false', 10);
add_filter('use_block_editor_for_page', '__return_false', 10);


function remove_uncategorized_links( $categories ){

	foreach ( $categories as $cat_key => $category ){
		if( 1 == $category->term_id ){
			unset( $categories[ $cat_key ] );
		}
	}

	return $categories;
	
} add_filter('get_the_categories', 'remove_uncategorized_links', 1);


