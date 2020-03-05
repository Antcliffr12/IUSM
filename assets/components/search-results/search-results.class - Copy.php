<?php


class SearchResults{

    private $is_multisite;
    private $query;
    private $type;
    private $version;
    private $author_ids = [];
    private $args;
    private $results = [];

    public function __construct($array)
    {
        $this->is_multisite = is_multisite();
        $this->query = isset($array['query']) && !empty($array['query']) ? sanitize_text_field($array['query']) : null;
        $this->version = isset($array['version']) ? $array['version'] : null;
        $this->type = isset($array['type']) && !empty($array['type'])? sanitize_text_field($array['type']) : null;
    }


    public function version(){
        return $this->version;
    }

    public function type(){
        return $this->type;
    }

    public function raw_query(){
        return $this->query;
    }


    public function is_author_search(){
        return isset($this->type) ? ($this->type == 'author' ? true : false) : false;
    }

    public function is_event_search(){
      return isset($this->type) ? ($this->type == 'event' ? true : false) : false;
    }

    public function is_news_search(){
      return isset($this->type) ? ($this->type == 'news' ? true : false) : false;
    }


    private function results(){

        if(!is_null($this->version) && $this->is_author_search() ){

            switch($this->version){
                case '0':
                    // Typed search
                    $search_string = esc_attr(trim($this->query));
                    $this->args = array (
                        'meta_query' => array(
                            'relation' => 'OR',
                            array(
                                'key'     => 'first_name',
                                'value'   => $search_string,
                                'compare' => 'LIKE'
                            ),
                            array(
                                'key'     => 'last_name',
                                'value'   => $search_string,
                                'compare' => 'LIKE'
                            ),
                        )
                    );
                    break;
                case '1':
                    // First Letter of Last Name search
                    $this->args = array(
                        'meta_key'      => 'last_name',
                        'meta_value'    => $this->query .'########', // The '########' sequence acts sort of like an unique identifier
                        'meta_compare'  => 'LIKE',
                    );
                    break;
                case '2':
                    // Search by Blog :: Special Type of Search, separate from everything else.
                    try {
                        // GET AUTHOR ID'S FOR CATEGORIES
                        $args = [
                            'post_status' => array('publish'),
                            'cat' => (int)$this->query,
                        ];
                        query_posts($args);
                        if (have_posts()) :
                            while (have_posts()) : the_post();
                                array_push($this->author_ids, get_the_author_meta('ID'));
                            endwhile;
                        endif;
                        wp_reset_postdata();

                        // NOW BUILD RESULTS LOOP
                        $authors = array_unique($this->author_ids);
                        if(isset($authors) && !empty($authors)) {
                            foreach ($authors as $id) {
                                $author_info = get_userdata($id);
                                array_push($this->results, [
                                    'id' => $id,
                                    'title' => $author_info->first_name . ' ' . $author_info->last_name,
                                    'link' => get_author_posts_url($id),
                                    'content' => LimitText(strip_tags(preg_replace( '/\[[^\]]+\]/', '', get_the_author_meta('description', $id))), 38),
                                ]);
                            }
                        }

                    }catch(\Exception $e){
                        $this->results = [];
                    }
                    break;
            }
            $this->args['order'] = 'ASC';
            if($this->version !== '2'){
                $author_query = new WP_User_Query( $this->args );
                $authors = $author_query->get_results();
                foreach ($authors as $author) {
                    $author_info = get_userdata($author->ID);
                    array_push($this->results, [
                        'id' => $author->ID,
                        'title' => $author_info->first_name . ' ' . $author_info->last_name,
                        'link' => get_author_posts_url($author->ID),
                        'content' => LimitText(strip_tags(preg_replace( '/\[[^\]]+\]/', '', get_the_author_meta('description', $author->ID))), 38),
                    ]);
                }

            }
        }else{
            // Build Result Array by looking at authors that match, and then results of all posts from all sites available.

            // AUTHOR CHECK
            $search_string = esc_attr(trim($this->query));
            $this->args = array (
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key'     => 'first_name',
                        'value'   => $search_string,
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key'     => 'last_name',
                        'value'   => $search_string,
                        'compare' => 'LIKE'
                    ),
                )
            );
            $author_query = new WP_User_Query( $this->args );
            $authors = $author_query->get_results();
            foreach ($authors as $author) {
                $author_info = get_userdata($author->ID);
                array_push($this->results, [
                    'id' => $author->ID,
                    'title' => $author_info->first_name . ' ' . $author_info->last_name,
                    'link' => get_author_posts_url($author->ID),
                    'content' => LimitText(strip_tags(preg_replace( '/\[[^\]]+\]/', '', get_the_author_meta('description', $author->ID))), 38),
                ]);
            }


            // POST CHECK
            $this->args = [
                's' => $this->query,
                'order' => 'ASC',
            ];
            if($this->is_multisite){ // MULTISITE CHECK
                $blog_ids = get_sites();
                foreach ($blog_ids as $value) {
                    switch_to_blog($value->blog_id);
                    $the_search = new WP_Query($this->args);
                    if ($the_search->have_posts()) :
                        while ($the_search->have_posts()) : $the_search->the_post();
                            array_push($this->results, [
                                'id' => get_the_ID(),
                                'title' => get_the_title(),
                                'link' => get_the_permalink(),
                                'content' => LimitText(strip_tags(preg_replace('/\[[^\]]+\]/', '', get_the_content())), 38),
                            ]);

                        endwhile;
                    endif;
                    wp_reset_query();
                    restore_current_blog();
                }

            }else{
                $the_search = new WP_Query($this->args);
                if ($the_search->have_posts()) :
                    while ($the_search->have_posts()) : $the_search->the_post();
                        array_push($this->results, [
                            'id' => get_the_ID(),
                            'title' => get_the_title(),
                            'link' => get_the_permalink(),
                            'content' => LimitText(strip_tags(preg_replace( '/\[[^\]]+\]/', '', get_the_content())), 38),
                        ]);
                    endwhile;
                endif;
                wp_reset_query();
            }

        }
        //news
        if(!is_null($this->version) && $this->is_news_search()){
          $search_string = esc_attr(trim($this->query));
          $this->args = array (
              'meta_query' => array(
                  'relation' => 'OR',
                  array(
                      'key'     => 'title',
                      'value'   => $search_string,
                      'compare' => 'LIKE',

                    ),
                    array(
                        'key'     => 'description',
                        'value'   => $search_string,
                        'compare' => 'LIKE',
                    ),
                  )
                );

          $arrayNews = $this->GetNewsData();
          // $this->results = array_merge($this->search($arrayNews, 'title', $search_string));
          $this->results = array_merge($this->search($arrayNews, 'title', $search_string), $this->search($arrayNews, 'description', $search_string));

          // echo count($this->results);
          // $this->search($arrayNews, 'title', $search_string);
          // print_r($arrayNews);
      }
      //events
      if(!is_null($this->version) && $this->is_event_search()){
        $search_string = esc_attr(trim($this->query));
        $this->args = array (
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key'     => 'summary',
                    'value'   => $search_string,
                    'compare' => 'LIKE',
                    ),
                    array(
                        'key'     => 'location',
                        'value'   => $search_string,
                        'compare' => 'LIKE',
                        ),

                    array(
                      'key'     => 'description',
                      'value'   => $search_string,
                      'compare' => 'LIKE',
                    ),

                  )
                );
                $this->args['order'] = 'ASC';

        $arrayEvents = $this->GetEventData();
        $this->results = array_merge($this->search($arrayEvents, 'summary', $search_string), $this->search($arrayEvents, 'location', $search_string));
        $this->results = array_unique(  array_merge($this->results, $this->search($arrayEvents, 'description', $search_string)), SORT_REGULAR);

      }
        return $this->results;
    }

    private function GetEventData(){
      $startDate = date("Y-m-01", strtotime('today UTC'));
      $endDate = date("Y-12-t", strtotime($startDate));

    $xmlUrl = 'https://uisapp2.iu.edu/ccl-prd/Xml.do?pubCalId=GRP21900&startDate='.$startDate.'&endDate='.$endDate;

      $xmlstr = file_get_contents($xmlUrl);
      $xmlcont = new SimpleXmlElement($xmlstr);

      $arrayEvents = array();
      foreach($xmlcont as $url){
        $event = array();

        foreach($url as $key => $value)
        {
          $event[$key] = $value;

        }
        $arrayEvents[] = $event;
      }
      return $arrayEvents;

    }


    private function GetNewsData(){
          $feed = 'https://www.iu.edu/~iunews/services/newsrooms/feeds/?format=rss20&id=82cfd9c9814f4e1c187e68ea4299b617&sort=date';

          $feed_to_array = file_get_contents($feed);
          $item = new SimpleXmlElement($feed_to_array);
          $arrayNews = array();
          foreach($item->channel->item as $items){
            $news = array();
            foreach($items as $key => $value){
              $news[$key] = $value;
            }
            $news[$key] = array_combine(range(1,count($news)), array_keys($news));
            $arrayNews[] = $news;
          }


          return $arrayNews;
    }




    /**
     * Returns: Void.
     */
    public function execute(){
        $searchResults = $this->results();

        if(empty($this->query)) {
          ?>
          <div class="result-item">
              <p class="no-results-found">Search query empty.</p>
          </div>
          <?php

        }elseif(empty($searchResults)){
          ?>
          <div class="result-item">
              <h2 class="no-results-found">Search Results not found.</h2>
          </div>
          <?php
        }else{
          if(!is_null($this->version) && $this->is_news_search() ){
            $s = $_GET['s'];

            foreach($searchResults as $result) {
                      $pubdate = $result['pubDate'];
                      $pubdate = date('F d, Y', strtotime($pubdate));

                      ?>
                      <div class="news">
                        <div class="result-item" data-postdate="<?= $pubdate ?>">
                            <li>
                              <h3><a target="_blank" class="title" href="<?= $result['link'] ?>"><?= $result['title'] ?></a></h3>
                              <span class="pubdate"><?= $pubdate; ?></span>
                              <a class="link"
                                 href="<?= $result['link'] ?>" target="_blank"><?= mb_strimwidth($result['link'], 0, 80, '...'); ?></a>
                              <p><?= $result['description'] ?></p>
                            </li>
                        </div>
                      </div>

                        <?php
                      }
                    ?>
                      <div class="load-more">
                        <div class="container">
                            <div class="col-md-12 text-center">
                                <a data-page="1" id="loadMore" data-url="<?php echo admin_url('admin-ajax.php') ?>" name="singlebutton" class=" btn-lg  btn btn-primary btn-big"><span>Load More</span></a>
                          </div>
                        </div>
                      </div>
                      <p class="totop">
                          <a href="#top">Back to top</a>
                      </p>
                      <script>

                        jQuery(".news").slice(0, 10).addClass('display');
                        // jQuery('no_news').hide();

                        document.getElementById("loadMore").onclick = function(e){
                            e.preventDefault();
                          jQuery('.news:hidden').slice(0 ,10).addClass('display');
                          if (jQuery(".news:hidden").length == 0) {
                              jQuery("#loadMore").fadeOut('slow');
                          }
                      }

                      if (jQuery(".news:hidden").length == 0) {
                          jQuery("#loadMore").hide();
                      }

                      jQuery('a[href=#top]').click(function () {
                          jQuery('body,html').animate({
                              scrollTop: 0
                          }, 600);
                          return false;
                      });

                      jQuery(window).scroll(function () {
                          if (jQuery(this).scrollTop() > 50) {
                              jQuery('.totop a').fadeIn();
                          } else {
                              jQuery('.totop a').fadeOut();
                          }
                      });

                      news = jQuery(".news").length;
                      if(news == 0){

                      }
                      </script>
                    <?php



          }elseif(!is_null($this->version) && $this->is_event_search()){
            foreach($searchResults as $result) {
              $todays_date = date('m-d-Y');
              if($todays_date <= $result['start-date-time']){
                ?>
                <div class="search_events">
                  <div class="result-item" data-postid="<?= $result['id'] ?>">
                      <a class="title" href="<?=esc_url( get_permalink( get_page_by_title( 'More Event' ) ) ) ?>?eventId=<?= $result['event-id']?>"><?= $result['summary'] ?></a>
                        <!-- <span class="pubdate"><?= $result['start-date-time'] ?></span> -->
                      <a class="link" target="_blank"
                         href="http://maps.google.com/?q=<?= $result['location']; ?>"><?= mb_strimwidth($result['location'], 0, 80, '...'); ?></a>
                        <p>
                          <?=  strip_tags(mb_strimwidth($result['description'],0,300,'...') ).'<a href="' . esc_url( get_permalink( get_page_by_title( 'More Event' ) ) ). '?eventId='.$result['event-id'].' " >More</a>' ?>
                        </p>
                  </div>
                </div>

                <?php
              }
            }
            ?>
              <div class="load-more">
                <div class="container">
                    <div class="col-md-12 text-center">
                        <a data-page="1" id="loadMore" data-url="<?php echo admin_url('admin-ajax.php') ?>" name="singlebutton" class=" btn-lg  btn btn-primary btn-big"><span>Load More</span></a>
                  </div>
                </div>
              </div>
              <p class="totop">
                  <a href="#top">Back to top</a>
              </p>
              <script>

                jQuery(".search_events").slice(0, 10).addClass('display');
                // jQuery('no_news').hide();

                document.getElementById("loadMore").onclick = function(e){
                    e.preventDefault();
                  jQuery('.search_events:hidden').slice(0 ,10).addClass('display');
                  if (jQuery(".search_events:hidden").length == 0) {
                      jQuery("#loadMore").fadeOut('slow');
                  }
              }

              if (jQuery(".search_events:hidden").length == 0) {
                  jQuery("#loadMore").hide();
              }

              jQuery('a[href=#top]').click(function () {
                  jQuery('body,html').animate({
                      scrollTop: 0
                  }, 600);
                  return false;
              });

              jQuery(window).scroll(function () {
                  if (jQuery(this).scrollTop() > 50) {
                      jQuery('.totop a').fadeIn();
                  } else {
                      jQuery('.totop a').fadeOut();
                  }
              });


              </script>
            <?php
          }
          else{
              foreach($searchResults as $result) {

                  ?>
                  <div class="result-item" data-postid="<?= $result['id'] ?>">
                      <a class="title" href="<?= $result['link'] ?>"><?= $result['title'] ?></a>
                      <a class="link"
                         href="<?= $result['link'] ?>"><?= mb_strimwidth($result['link'], 0, 80, '...'); ?></a>
                      <p><?= $result['content'] ?></p>
                  </div>
                  <?php
              }

        }
      }


    }


    public function search($array, $key, $value){

        $results = array();

        if (is_array($array)) {
            //if (isset($array[$key]) &&  $array[$key] == $value) {
            if (isset($array[$key]) &&  preg_match(strtolower("/$value/"), strtolower($array[$key]))  ) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {

                $results = array_merge($results, $this->search($subarray, $key, $value));
            }
        }

        return $results;
    }

}
