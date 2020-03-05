<?php

$is_multiSite = is_multisite();

function recent_posts($atts = array()) {
    extract( shortcode_atts( array(
        'title' => '',
        'description' => '',
        'button_title' => '',
        'button_url' => '',
        'button_target' => '',
        'button_rel' => '',
        'vc_link' => '',
        'post_number' => '',
	    'rss_feed' => '',
	    'rss_feed_number' => '',
        'category_link_settings' => '',
        'recent_posts_site_selection' => '',
    ), $atts ));


    // Variable $link comes from the vc_link type. We then parse out the pipe delimited string it returns to build
    // the link's values, which are then placed correctly in the view template.
    $linkAttrs = parse_vc_link($vc_link);

    $button_title = '';
    $button_url = '';
    $button_target = '';
    $button_rel = '';

    if(isset($linkAttrs['url']) && !empty($linkAttrs['url'])) {
        $button_url = isset($linkAttrs['url']) ? urldecode($linkAttrs['url']) : '';
        $button_title = isset($linkAttrs['title']) ? urldecode($linkAttrs['title']) : '';
        $button_target = isset($linkAttrs['target']) ? urldecode($linkAttrs['target']) : '';
        $button_rel = isset($linkAttrs['rel']) ? $linkAttrs['rel'] : '';
    }

    if(is_multisite())
        $post_number = -1;

    return render_component('recent-posts', [
        'title' => $title,
        'description' => $description,
        'button_title' => $button_title,
        'button_url' => $button_url,
        'button_target' => $button_target,
        'button_rel' => $button_rel,
        'post_number' => $post_number,
        'vc_link' => '',
	    'rss_feed' => $rss_feed,
	    'rss_feed_number' => $rss_feed_number,
        'category_link_settings' => $category_link_settings,
        'recent_posts_site_selection' => $recent_posts_site_selection,
    ]);
}
add_shortcode('recent-posts', 'recent_posts');


function recentPostNumbers(){
    $numArray = [];
    for($i = 1; $i <= 50; $i++){
        array_push($numArray, $i);
    }
    return $numArray;
}

$recentPosts = [];
$blogSites = [];

        /**
         * Add settings dependent on multisite configuration
         */
        if($is_multiSite && function_exists('get_sites')):

            $sites = get_sites(['deleted' => 0]);

            $siteArray = [];
            foreach($sites as $site){
                $siteArray[$site->domain . $site->path] = $site->blog_id;
            }

            $blogSites = array(
                'type' => 'param_group',
                'heading' => __("Recent Posts Site Selection", ''),
                'value' => '',
                'param_name' => 'recent_posts_site_selection',
                'description' => __('', ''),
                'group' => 'Site Selection',
                'params' => array(
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Site', ''),
                        'value' => $siteArray,
                        'param_name' => 'site_id',
                        'description' => __('List of avaliable sites to choose get recent posts from.', ''),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Recent Posts Length",''),
                        "param_name" => "site_post_number",
                        "value" => recentPostNumbers(),
                        "description" => __('Number of Posts to pull from selected site.', ''),
                    ),
                )
            );

        else:
            $recentPosts = array(
                "type" => "dropdown",
                "heading" => __("Recent Posts Length",''),
                "param_name" => "post_number",
                "value" => recentPostNumbers(),
                "description" => __('Sets number of recent posts to loop', ''),
            );
        endif;



//        $rssFeedOverride = [
//        	'type' => 'param_group',
//	        'heading' => __("RSS Feed Settings"),
//	        'value' => '',
//	        'param_name' => 'rss_feed_settings',
//	        'description' => __('Provides settings for adding an external RSS Feed to plugin. Overrides recent post loop.'),
//	        'group' => 'Rss Feed',
//	        'params' => [

//	        ],
//
//        ];



if( function_exists('vc_map')) {
	vc_map(array(
		"name" => __("Recent Posts", ""),
		"base" => "recent-posts",
		'icon' => THEME_PATH . '/assets/images/icons/full-blog.png',
		'description' => __('Displays a section of recent posts', ''),
		'category' => __('IUSM Components'),
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __("Title", ""),
				"param_name" => "title",
				"value" => "",
				"description" => __("Enter a title.", "")
			),
			array(
				"type" => "textarea",
				"heading" => __("Description", ""),
				"param_name" => "description",
				"value" => "",
				"description" => __("Enter a description.", "")
			),
			array(
				"type" => "vc_link", //Link selection. Then in shortcodes html output, use $href = vc_build_link( $href ); to parse link attribute
				"heading" => __("View More Button Link", ""),
				"param_name" => "vc_link",
				"value" => "",
				"description" => __("Enter a link info.", "")
			),

			array(
				'type' => 'param_group',
				'heading' => __("Category Link Settings", ''),
				'value' => '',
				'param_name' => 'category_link_settings',
				'description' => __('Adds static links for category site pages. Use the drop down arrow on each item on the right to edit settings content.', ''),
				'group' => 'Category Links',
				'params' => array(
					array(
						'type' => 'attach_image',
						'value' => '',
						'heading' => __('Category Image', ''),
						'param_name' => 'category_link_image',
					),
					array(
						'type' => 'textfield',
						'value' => '',
						'heading' => __('Link Text', ''),
						'param_name' => 'category_link_text',
					),
					array(
						'type' => 'textfield',
						'value' => '',
						'heading' => __('Link path for category', ''),
						'param_name' => 'category_link',
					),
				)
			),
			$recentPosts,
			array(
				'type' => 'textfield',
				'heading' => __("Rss Feed Link"),
				'param_name' => 'rss_feed',
				'value' => '',
				'description' => __('Add Rss Feed url link to override custom blog posts feed. ', ''),
			),
			array(
				"type" => "dropdown",
				"heading" => __("RSS Feed Length", ''),
				"param_name" => "rss_feed_number",
				"value" => recentPostNumbers(),
				"description" => __('Sets number of rss feeds items in loop.', ''),
			),
			$blogSites,
		)
	));
}

// Parse pipe delaminated resulting from the vc_link type of visual composer.
function parse_vc_link($link){
    $linkValues = explode('|', $link);
    $linkArray = [];
    foreach($linkValues as $value){
        if(!empty($value)) {
            $part = explode(":", $value);
            $linkArray[$part[0]] = $part[1];
        }
    }
    return $linkArray;
}
