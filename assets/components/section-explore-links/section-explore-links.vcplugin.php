<?php
function sc_component_section_explore_links($atts) {
	global $menu_tree, $post, $item;
	extract( shortcode_atts( array(
		'title' => 'Explore',
		'body' => 'Intro text goes here',
	), $atts ));
	$oid = get_post_meta($post->ID, '_menu_item_object_id', true);
	
	if ($oid == '') {
		$oid = $post->ID;
	}

	$links = (count($branch) > 0 && isset($branch[0]->wpse_children)) ? $branch[0]->wpse_children : [];
	//$target = $item['target'];

	return render_component('section-explore-links', [
		'title' => $title,
		'body' => $body,
		'links' => $links,
	]);
}
add_shortcode('section_explore_links', 'sc_component_section_explore_links');

if( function_exists('vc_map')) {
	vc_map(array(
		'name' => __('Fullwidth Component 3'),
		'base' => 'section_explore_links',
		'icon' => THEME_PATH . '/assets/components/section-explore-links/vc-icon.png',
		'description' => __('Fullwidth #3'),
		'category' => __('IUSM Components'),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __('Title'),
				'param_name' => 'title',
				'value' => '',
				'description' => __('Enter a title here')
			),
			array(
				'type' => 'textarea',
				'heading' => __('Body'),
				'param_name' => 'body',
				'value' => '',
				'description' => __('Enter the body text here')
			),
		)
	));
}
