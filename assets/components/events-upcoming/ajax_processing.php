<?php

class UpcomingEventsAjax{

    public function __construct()
    {
        //Actions referenced by ajax
        add_action('wp_ajax_iu_upcoming_events_return', array( $this, 'ProcessData'));
        add_action('wp_ajax_nopriv_iu_upcoming_events_return', array( $this, 'ProcessData'));
    }

    public function ProcessData(){

        $check = true;
        $itemArray = array();
        if( !isset( $_POST['nounce']) || !wp_verify_nonce($_POST['nounce'], 'iu-nounce'))
            $check = false;

        $counter = 3;
        $count = $_POST['count'];
        $today = date('m-d-Y g:i a');
        $args = [
            'post_status' => 'publish',
            'post_type' => 'post',
            'meta_key' => 'start-date-time',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'category'    => 'event',
            'posts_per_page' => (int)$counter + 1,
//            'meta_query' => [
//                [
//                    'key' => 'end-date-time',
//                    'value' => $today,
//                    'compare' => '>=',
//                ]
//            ],
            'offset' => $count,
        ];

        $query = new WP_Query($args);
        $postsPerPage = $query->post_count;

        // Sets the output array to have only 8. Also checks if there are any more posts left.
        $checkAmount = $counter < $postsPerPage;
        $postsPerPage = $checkAmount ? $postsPerPage - 2 : $postsPerPage - 1;

        $newCount = $checkAmount ? $query->post_count - 1 + $count : $query->post_count + $count;

        for($i = 0; $i <= $postsPerPage;$i++) {
            $post = $query->posts[$i];
            $id = $post->ID;
            $content = get_post_field('post_content', $id);
            $content = str_replace(']]>', ']]&gt;', $content);
            array_push($itemArray, [
                'id' => $id,
                'title' => get_the_title($id),
                'content' => $content,
                'location' => get_post_meta($id, 'location', true),
                'url' => get_post_meta($id, 'event-url', true),
                'start_date' => get_post_meta($id, 'start-date-time', true),
                'end_date' => get_post_meta($id, 'end-date-time', true),
                'contact_email' => get_post_meta($id, 'contact-email', true),
                'calendar_id' => get_post_meta($id, 'calendar-id', true),
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
new UpcomingEventsAjax();