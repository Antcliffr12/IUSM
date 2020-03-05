<?php
class NewsFeed{
  public static function GetFeed($url){
      if(!empty($url)) {
          try {
              $contents = wp_remote_get($url);
              $contents = wp_remote_retrieve_body($contents);

              $rss = new DOMDocument();
              $rss->recover=true;
              $feed = array();
              if(!empty($contents)) {
                  $rss->loadXML($contents);
                  /* Have to have all tags in feed */
                  // All Items will have an image. Therefore count will be the same.
                  // $media = $rss->getElementsByTagName('image');
                  //
                  // $mediaCount = $media->length;
                  // $mediaArray = [];
                  // if ($mediaCount > 0) {
                  //
                  //     for ($i = 0; $i <= $mediaCount; $i++) {
                  //         $mediaArray[$i] = $media->item($i)->nodeValue;
                  //     }
                  // }


                  foreach ($rss->getElementsByTagName('item') as $itemKey => $node) {

                      $item = [
                          'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                          'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
                          'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
                          //'image' => isset($mediaArray[$itemKey]) ? $mediaArray[$itemKey] : '',
                      ];
                      //checks if has Image tag in Rss feed then puts in back in $item array
                      $image = $node->getElementsByTagName('image');
                      if($image->length > 0){
                        $item['image'] = $image->item(0)->nodeValue;
                      }
                      array_push($feed, $item);

                      // echo '<pre>';
                      // var_dump($item);
                      // echo '<pre>';
                  }
              }
              return $feed;
          }catch(\Exception $exception){
              var_dump($exception->getMessage());
          }
      }else{
          return '';
      }
  }


}
