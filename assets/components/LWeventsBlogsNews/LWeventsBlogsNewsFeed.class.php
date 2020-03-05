<?php
class NewsBlogs_Feed{

    public static function GetNewsBlogFeed($url){
        if(!empty($url)) {
            try {
                $contents = wp_remote_get($url);
                $contents = wp_remote_retrieve_body($contents);
  
                $rss = new DOMDocument();
                $rss->recover=true;
                $feed = array();
                if(!empty($contents)) {
                    $rss->loadXML($contents);
  
                    // All Items will have an media:tag. Therefore count will be the same.
                    $media = $rss->getElementsByTagNameNS('http://search.yahoo.com/mrss/', 'thumbnail');
                    $mediaCount = $media->length;
                    $mediaArray = [];
                    if ($mediaCount != 0) {
                        for ($i = 0; $i <= $mediaCount - 1; $i++) {
                            $mediaArray[$i] = $media->item($i)->getAttribute('url');
                        }
                    }
  
  
                    foreach ($rss->getElementsByTagName('item') as $itemKey => $node) {
                        $item = [
                            'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                            'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
                            'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
                            'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
                            'image' => isset($mediaArray[$itemKey]) ? $mediaArray[$itemKey] : '',
                        ];
                        array_push($feed, $item);
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
  