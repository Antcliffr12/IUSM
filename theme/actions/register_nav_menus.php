<?php

function RegisterMenus(){
    register_nav_menus(array(
        'top_header' => __( 'Top Header', 'iusm'),
        'main' => __('Main', 'iusm'),
        'blog' => __('Blog', 'iusm'),
		    'event' => __('Event', 'iusm'),
        'news' => __('News', 'iusm'),
        'footer' => __('Footer', 'iusm'),
        'campuses' => __('Campuses', 'iusm'),
    ));
}

add_action('init', 'RegisterMenus');
