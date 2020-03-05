<?php


function RECENT_POST_IMAGE_DATA($is_multisite = false, $siteSelections = []){
    $postIdArray = [];

    if($is_multisite == false) {
        $imageArgs = [
            'post_type' => 'post',
            'cat' => -1,
            'orderby' => 'post_date',
            'order' => 'DESC',
            'posts_per_page' => 30,
        ];
        $loop = new WP_Query($imageArgs);
        if ($loop->have_posts()) :
            while ($loop->have_posts()) : $loop->the_post();
                $image_id = get_post_thumbnail_id(get_the_ID());
                $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                $image_alt = !empty($image_alt) ? $image_alt : get_the_title(get_the_ID());
                $image_src = wp_get_attachment_image_src($image_id, 'iu-large');
                $image_src = isset($image_src[0]) ? $image_src[0] : '';

                $postIdArray[strtotime(get_the_date())] = [
                    'post_id' => get_the_ID(),
                    'imageAlt' => $image_alt,
                    'imageSrc' => $image_src,
                    'permalink' => get_permalink(),
                    'title' => get_the_title(),
                ];
            endwhile;
        endif;
        wp_reset_postdata();
        ksort($postIdArray, 1);
    }else{

        if(!empty($siteSelections)){
            foreach($siteSelections as $siteSelection):
                switch_to_blog($siteSelection->site_id);
                $postPerPage = (isset($siteSelection->site_post_number) && !empty($siteSelection->site_post_number)) ? $siteSelection->site_post_number : 20;

                $imageArgs = [
                    'post_type' => 'post',
                    'cat' => -1,
                    'orderby' => 'post_date',
                    'order' => 'DESC',
                    'posts_per_page' => $postPerPage,
                ];
                $loop = new WP_Query($imageArgs);
                if ($loop->have_posts()) :
                    while ($loop->have_posts()) : $loop->the_post();

                        $image_id = get_post_thumbnail_id(get_the_ID());
                        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                        $image_alt = !empty($image_alt) ? $image_alt : get_the_title(get_the_ID());
                        $image_src = wp_get_attachment_image_src($image_id, 'iu-large');
                        $image_src = isset($image_src[0]) ? $image_src[0] : '';

                        $postIdArray[strtotime(get_the_date())] = [
                            'post_id' => get_the_ID(),
                            'imageAlt' => $image_alt,
                            'imageSrc' => $image_src,
                            'permalink' => get_permalink(),
                            'title' => get_the_title(),
                        ];
                    endwhile;
                endif;
                wp_reset_postdata();
                restore_current_blog();
            endforeach;


            ksort($postIdArray, 1);
        }
    }

    $returnArray = [];
    foreach($postIdArray as $value){
        array_push($returnArray, $value);
    }



    return $returnArray;

}



function RECENT_POST_CONTENT_DATA($is_multisite = false, $siteSelections = []){
        $postIdArray = [];

        if($is_multisite == false) {
            $imageArgs = [
                'post_type' => 'post',
                'cat' => -1,
                'orderby' => 'post_date',
                'order' => 'DESC',
                'posts_per_page' => 30,
            ];
            $loop = new WP_Query($imageArgs);
            if ($loop->have_posts()) :
                while ($loop->have_posts()) : $loop->the_post();
                    $category = get_the_category(get_the_ID());
                    $categoryName = $category[0]->name;
                    $term_id = $category[0]->term_id;
                    $postIdArray[strtotime(get_the_date())] = [
                        'post_id' => get_the_ID(),
                        'title' => get_the_title(),
                        'permalink' => get_permalink(),
                        'termLink' => !empty($term_id) ? get_term_link($term_id) : '',
                        'categoryName' => $categoryName,
                        'content' => get_the_content(),
                    ];
                endwhile;
            endif;
            wp_reset_postdata();
            ksort($postIdArray, 1);
        }else{

            if(!empty($siteSelections)){
                foreach($siteSelections as $siteSelection):
                    switch_to_blog($siteSelection->site_id);
                    $postPerPage = (isset($siteSelection->site_post_number) && !empty($siteSelection->site_post_number)) ? $siteSelection->site_post_number : 20;
                    $imageArgs = [
                        'post_type' => 'post',
                        'cat' => -1,
                        'orderby' => 'post_date',
                        'order' => 'DESC',
                        'posts_per_page' => $postPerPage,
                    ];
                    $loop = new WP_Query($imageArgs);
                    if ($loop->have_posts()) :
                        while ($loop->have_posts()) : $loop->the_post();
                            $category = get_the_category(get_the_ID());
                            $categoryName = $category[0]->name;
                            $term_id = $category[0]->term_id;
                            $postIdArray[strtotime(get_the_date())] = [
                                'post_id' => get_the_ID(),
                                'title' => get_the_title(),
                                'permalink' => get_permalink(),
                                'termLink' => !empty($term_id) ? get_term_link($term_id) : '',
                                'categoryName' => !empty($categoryName) ? $categoryName : '',
                                'content' => get_the_content(),
                            ];
                        endwhile;
                    endif;
                    wp_reset_postdata();
                    restore_current_blog();
                endforeach;
            }
            ksort($postIdArray, 1);

        }


        $returnArray = [];
        foreach($postIdArray as $value){
            array_push($returnArray, $value);
        }

        return $returnArray;
}


/**
 * @param $settings : comes in as an object.
 * @return array
 */
function CATEGORY_DATA($settings){
    $settingsArray = [];
    if(!empty($settings)):
        foreach ($settings as $setting) {
            $imageSrc = wp_get_attachment_image_src($setting->category_link_image, 'iu-small');
            $imageSrc = isset($imageSrc[0]) ? $imageSrc[0] : '';
            array_push($settingsArray, [
                'title' => $setting->category_link_text,
                'link' => $setting->category_link,
                'imageSrc' => $imageSrc,
            ]);
        }
    endif;
    return $settingsArray;
}


function RSS_FEED($url){

		$rss = new DOMDocument();
		$rss->load(trim($url));
		$feed = array();

		foreach ($rss->getElementsByTagName('item') as $node) {
			$item = [
				'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
				'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
				'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
				'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
			];
			array_push($feed, $item);

		}
		
//		die('<pre>'.print_r($feed, 1).'</pre>');
		return $feed;
}