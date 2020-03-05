<?php
//
//// ADD NEW COLUMN
//function is_featured_columns_head($defaults) {
//    $defaults['is_featured_post'] = 'Featured Post';
//    return $defaults;
//}
//
//// SHOW THE FEATURED COLUMN
//function is_featured_content_columns_content($column_name, $post_ID) {
//    if ($column_name == 'is_featured_post') {
//        $value = get_post_meta( $post_ID, 'featured_checkbox', true );
//        $returnValue = !empty($value) && $value === 'on' ? '<span style="font-size:40px !important;" class="dashicons dashicons-yes"></span>' : '';
//        echo $returnValue;
//    }
//}
//
//
//add_filter('manage_posts_columns', 'is_featured_columns_head');
//add_action('manage_posts_custom_column', 'is_featured_content_columns_content', 10, 2);