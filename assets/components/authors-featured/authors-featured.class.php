<?php

class AuthorsFeatured {

    private $args = [];
    private $authors;
    private $author_info = [];

    public function __construct()
    {
        $this->args = [
            'role__not_in' => ['Administrator'],
        ];
    }

    public function set_usermeta(){
        $this->authors = get_users($this->args);

        foreach ($this->authors as $author) {
            $query = new wp_query([
                'author' => $author->ID,
                'post_status'       => 'publish',
                'posts_per_page' => '-1',
            ]);

            $posts = $query->posts;
            $postcount = $query->post_count;
            $sharecount = 0;
            $totalsharecount = 0;
            $viewcount = 0;
            $totalviewcount = 0;

            foreach ($posts as $post) {
                $viewcount = (function_exists('pvc_get_post_views'))?pvc_get_post_views($post->ID):0;
                $totalviewcount += $viewcount;

                $post_url = get_permalink($post->ID);
                $post_url = rtrim($post_url, '/');

                //making a request to the add this api for shares using the post url we just got
                $sharerequest = wp_remote_get("https://api-public.addthis.com/url/shares.json?url=".$post_url."%2F");

                //decoding the json data we got back from the request and storing the share count in $sharecount
                $sharecount = json_decode($sharerequest['body'], true);
                $sharecount = $sharecount['shares'];
                $totalsharecount += $sharecount;
            }

            $this->author_info[$author->ID] = [
                'id'         => $author->ID,
                'views'      => $totalviewcount,
                'shares'     => $totalsharecount,
                'postcount'  => $postcount,
                'popularity' => $totalviewcount+$totalsharecount,
            ];

//            usort($this->author_info, [$this,'sortByPopularity']);
            $this->update_usermeta($this->author_info);
        }

        return $this->author_info;

    }

    private function update_usermeta($author_info){
        foreach($author_info as $key=>$value){
            update_user_meta($value['id'], 'views', $value['views']);
            update_user_meta($value['id'], 'shares', $value['shares']);
            update_user_meta($value['id'], 'postcount', $value['postcount']);
            update_user_meta($value['id'], 'popularity', $value['popularity']);
        }
    }

    private function sortByPopularity($a, $b) {
        $a = $a['popularity'];
        $b = $b['popularity'];

        if ($a == $b) {
            return 0;
        }
        return ($a > $b)?-1:1;
    }

}