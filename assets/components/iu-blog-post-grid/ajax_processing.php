<?php

class BlogAjax{

    public function __construct()
    {
        //Actions referenced by ajax
        add_action('wp_ajax_iu_blog_posts_return', array( $this, 'ProcessData'));
        add_action('wp_ajax_nopriv_iu_blog_posts_return', array( $this, 'ProcessData'));
    }

    public function ProcessData(){

        $check = true;

        if( !isset( $_POST['nounce']) || !wp_verify_nonce($_POST['nounce'], 'iu-nounce'))
            $check = false;

        $itemArray = array();

        $count = $_POST['count'];

        $args = [
            'post_status' => 'publish',
            'post_type' => 'post',
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => 10,
            'offset' => $count,
        ];
        $query = new WP_Query($args);
        $defaultImage = THEME_PATH . '/assets/images/blog-list-placeholder.gif';
        $postsPerPage = $query->post_count;

        // Sets the output array to have only 9. Also checks if there are any more posts left.
        $checkAmount = 9 < $postsPerPage;
        $postsPerPage = $checkAmount ? $postsPerPage - 2 : $postsPerPage - 1;

            $newCount = $checkAmount ? $query->post_count - 1 + $count : $query->post_count + $count;

        for($i = 0; $i <= $postsPerPage;$i++) {
            $removeMargin = (($i+1) % 3) == 0 ? true : false;
            $post = $query->posts[$i];
            $postId = $post->ID;
            $postThumbnail = has_post_thumbnail($postId) ? get_the_post_thumbnail_url($postId, 'iu-medium') : $defaultImage;
            array_push($itemArray, [
                'title' => get_the_title($postId),
                'permalink' => get_permalink($postId),
                'postThumbnail' => $postThumbnail,
                'removeRightMargin' => $removeMargin,
            ]);

        }

        wp_reset_postdata();

        $returnArray = array(
            'success' => $check,
            'post_items' => $itemArray,
            'count' => $newCount,
            'empty' => !$checkAmount,
            'count_test' => $_POST['count'],
        );

        echo json_encode($returnArray);
        die();
    }
}
new BlogAjax();