<?php
// Visual composer parameters and parameter groups shared by multiple components
$vc_shared_params_iu_bg_colors = array(
	'type' => 'dropdown',
	'heading' => __( 'Background Color', '' ),
	'param_name' => 'bg_color',
	'value' => array(
		__('None', '') => '',
		__('White', '') => 'bg-white',
		__('IU Dark Crimson', '') => 'bg-iu-dark-crimson',
		__('IU Crimson', '') => 'bg-iu-crimson',
		__('IU Cream', '') => 'bg-iu-cream',
		__('IU Dark Gold', '') => 'bg-iu-dark-gold',
		__('IU Gold', '') => 'bg-iu-gold',
		__('IU Dark Mint', '') => 'bg-iu-dark-mint',
		__('IU Mint', '') => 'bg-iu-mint',
		__('IU Dark Midnight', '') => 'bg-iu-dark-midnight',
		__('IU Midnight', '') => 'bg-iu-midnight',
		__('IU Dark Majestic', '') => 'bg-iu-dark-majestic',
		__('IU Majestic', '') => 'bg-iu-majestic',
		__('IU Dark Limestone', '') => 'bg-iu-dark-limestone',
		__('IU Limestone', '') => 'bg-iu-limestone',
		__('IU Black', '') => 'bg-iu-black',
		__('IU Mahogany', '') => 'bg-iu-mahogany',
	),
	'description' => __( 'Select an optional background color for the element' ),
	'std' => '',
);



$vc_shared_params_iu_font_colors = array(
	'type' => 'dropdown',
	'heading' => __( 'Font Color', '' ),
	'param_name' => 'font_color',
	'value' => array(
		__('None', '') => '',
		__('White', '') => 'color-white',
		__('IU Dark Crimson', '') => 'color-iu-dark-crimson',
		__('IU Crimson', '') => 'color-iu-crimson',
		__('IU Cream', '') => 'color-iu-cream',
		__('IU Dark Gold', '') => 'color-iu-dark-gold',
		__('IU Gold', '') => 'color-iu-gold',
		__('IU Dark Mint', '') => 'color-iu-dark-mint',
		__('IU Mint', '') => 'color-iu-mint',
		__('IU Dark Midnight', '') => 'color-iu-dark-midnight',
		__('IU Midnight', '') => 'color-iu-midnight',
		__('IU Dark Majestic', '') => 'color-iu-dark-majestic',
		__('IU Majestic', '') => 'color-iu-majestic',
		__('IU Dark Limestone', '') => 'color-iu-dark-limestone',
		__('IU Limestone', '') => 'color-iu-limestone',
		__('IU Black', '') => 'color-iu-black',
		__('IU Mahogany', '') => 'color-iu-mahogany',
	),
	'description' => __( 'Select an optional font color for the element' ),
	'std' => '',
);



$vc_shared_params_iu_link_buttons = array(
	array(
		'type' => 'textfield',
		'heading' => __( 'Label' ),
		'param_name' => 'label',
		'value' => '',
		'description' => __( 'Provide the link button label text' )
	),
	array(
		'type' => 'textfield',
		'heading' => __( 'Link' ),
		'param_name' => 'link',
		'value' => '',
		'description' => __( 'Provide the link button URL' )
	),
	array(
		'type' => 'dropdown',
		'heading' => __( 'Link target' ),
		'param_name' => 'link_target',
		'value' => array(
			'Same window (default)' => '_self',
			'New window' => '_blank',
		),
		'std' => '_self',
		'description' => __( 'Set whether link opens in the same window/tab' )
	),
);

$vc_shared_params_iu_buttons_group = array(
	'type' => 'param_group',
	'value' => '',
	'heading' => __( 'Buttons (optional)' ),
	'param_name' => 'buttons',
	'description' => __( 'Add multiple buttons below content' ),
	'group' => 'Content',
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Button Text' ),
			'param_name' => 'button_text',
			'value' => '',
			'group' => 'Content',
			'description' => __( 'Provide the button label text' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Button Link' ),
			'param_name' => 'button_link',
			'value' => '',
			'group' => 'Content',
			'description' => __( 'Provide the button link URL' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Add IU Logo' ),
			'param_name' => 'iu_logo',
			'value' => array(
				'No' => '',
				'Yes' => 'add-logo',
			),
			'std' => '',
			'description' => __( 'Adds the IU Logo left of button text' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Link target' ),
			'param_name' => 'button_link_target',
			'value' => array(
				'Same window (default)' => '_self',
				'New window' => '_blank',
			),
			'std' => '_self',
			'description' => __( 'Set whether link opens in the same window/tab' )
		),
	),
);

$vc_shared_params_feed_aggregator = array(
	'type' => 'param_group',
	'value' => '',
	'heading' => __( 'RSS Feed Sources' ),
	'param_name' => 'rss_feeds',
	'description' => __( 'Define the RSS feeds that will be used to pull content for this element.' ),
	'group' => 'Content',
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Feed URL' ),
			'param_name' => 'feed_url',
			'value' => '',
			'description' => __( 'Provide the URL to the feed.' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Max Items' ),
			'param_name' => 'feed_maxitems',
			'value' => [
			    1,
                2,
                3,
                4,
                5,
                6,
                7,
                8,
                9,
                10,
                11,
                12,
                13,
                14,
                15,
                16,
                17,
                18,
                19,
                20,
            ],
			'std' => 1,
			'description' => __( 'Set the maximum number of items to pull from this feed.' ),
		),
	),
);

// Common Visual Composer field configuration for all IU Content Grid variants
$vc_shared_params_iu_grid_defaults = array(
	array(
		'type' => 'dropdown',
		'heading' => __( 'Grid Layout', '' ),
		'param_name' => 'columns',
		'value' => array(
			__('1 Column') => 1,
			__('2 Columns') => 2,
			__('3 Columns') => 3,
			__('4 Columns') => 4,
		),
		'description' => __( 'Select the number of columns this grid will use at the largest screen size.' ),
		'std' => 3,
	),
	array(
		'type' => 'textfield',
		'heading' => __( 'Title' ),
		'param_name' => 'title',
		'value' => '',
		'description' => __( 'Optional title text to be displayed above the grid items.' )
	),
	array(
		'type' => 'textarea',
		'heading' => __( 'Text' ),
		'param_name' => 'intro',
		'value' => '',
		'description' => __( 'Optional intro text to be displayed above the grid items.' )
	),
	array_merge($vc_shared_params_iu_bg_colors, []),
	array(
		'type' => 'textfield',
		'heading' => __( 'Additional CSS Classes' ),
		'param_name' => 'extra_classes',
		'value' => '',
		'description' => __( 'Optional space-separated list of CSS class names to apply to the grid container.' )
	),
);



// Category picker
if(function_exists('vc_shared_params_categories')){
function vc_shared_params_categories() {
	$categories = get_categories();
	$catArray = ['Select'];
	foreach ($categories as $category) {
		array_push($catArray, $category->name);
	}
	return [
		'type' => 'dropdown',
		'value' => $catArray,
		'description' => __('Select a Category'),
	];
}
}
