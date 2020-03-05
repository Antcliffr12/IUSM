<?php

class PublicationsFeed{

    public static function GetFeed($url){
        if(!empty($url)) {
            $rss = new DOMDocument();
            $rss->loadXML(file_get_contents($url));

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
            return $feed;
        }else{
            return '';
        }
    }
}
