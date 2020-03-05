<?php
/* Template Name: All Blogs LInks */
global $wpdb;

// $querystr = "
//     SELECT * 
//     FROM $wpdb->posts
//     LEFT JOIN $wpdb->term_relationships ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id)
//     LEFT JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
//     LEFT JOIN $wpdb->terms ON ($wpdb->term_taxonomy.term_id = $wpdb->terms.term_id)
//     WHERE $wpdb->posts.post_type = 'stc' 
//     AND $wpdb->
  
// ";
// $pageposts = $wpdb->get_results($wpdb->prepare($querystr, array($parent_post_slug)));

// foreach($pageposts as $posts){
//   echo $posts->post_title . ' ' . $posts->slug . ' <br>';
// }