<?php

function theme_scripts(){
    wp_enqueue_style('themeStyles', get_stylesheet_directory_uri() . '/assets/bundles/styles.css', '1.3');
    wp_register_script('themeScripts', get_stylesheet_directory_uri() . '/assets/bundles/scripts.js', array('jquery'), '1.0', true);
   
    wp_enqueue_style('themeStyles', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', '1.3');

   wp_register_script('jQueryScript', 'https://code.jquery.com/jquery-3.4.0.min.js', '3.0');

    wp_register_script('jQueryUI', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js');

    if( is_page( array( '29625','29627' ) ) ) {
        wp_register_script('AccessScript', '//tag.brandcdn.com/autoscript/indianauniversityschoolofmedicine_vg5wwk1rovjqvda9/access_trial_display.js');
        wp_enqueue_script('AccessScript');

    }
   
    wp_localize_script('themeScripts', 'iu_vars', array(
        'iu_nounce' => wp_create_nonce('iu-nounce'),
        'iu_ajax_url' => admin_url('admin-ajax.php'),
        'rest_api_root' => esc_url_raw( rest_url() ),
    ));
    wp_enqueue_script('themeScripts');
    wp_enqueue_script('jQueryScript');
    wp_enqueue_script('jQueryUI');


}
add_action('wp_enqueue_scripts' , 'theme_scripts', 9);

function theme_admin_scripts(){

    wp_localize_script('themeScripts', 'iu_vars', array(
        'iu_nounce' => wp_create_nonce('iu-nounce'),
        'iu_ajax_url' => admin_url('admin-ajax.php'),
        'rest_api_root' => esc_url_raw( rest_url() ),
    ));

    wp_enqueue_style('admin-themeStyles', get_stylesheet_directory_uri() . '/assets/bundles/styles-admin.css', '1.0');

	wp_enqueue_media();
	// Registers and enqueues the required javascript.
	wp_register_script( 'meta-box-image', get_stylesheet_directory_uri() . '/assets/bundles/admin-scripts.js', array( 'jquery' ) );
	wp_localize_script( 'meta-box-image', 'meta_image', array(
			'title' => __( 'Choose or Upload an Image', '' ),
			'button' => __( 'Use this image', '' ),
	));

	wp_enqueue_script('meta-box-image' );
    wp_enqueue_script('themeScripts');
    wp_enqueue_script('jQueryScript');
    wp_enqueue_script('jQueryUI');



}
add_action('admin_enqueue_scripts' , 'theme_admin_scripts' );
