<?php
//include_once(ABSPATH . WPINC . '/rss.php');
class IUSM_Feed{

    private $count = 1;

    public function set_number($numberOfFeedItems){
        $this->count = (int)$numberOfFeedItems;
    }

    public function get_feed($source, $_isEvents = false){

        if(!empty($source) && !is_null($source)):
            $rssContent = file_get_contents($source);
            $sxe = new SimpleXmlElement($rssContent);
            $feed = $this->parse_feed($sxe, $_isEvents);
            return $feed;
        else:
            return '';
        endif;
    }

    private function parse_feed($rss, $_isEvents)
    {

        $eventsFeed = $_isEvents;
        $count = $this->count;
        $total = count($rss->channel->item);

        $iterator = $count <= $total ? $count : $total;

        $rssContent = [];
        for($i = 0; $i <= $iterator - 1; $i++){
            $entry = $rss->channel->item[$i];

            $title = $entry->title;
            $link = (string)$entry->link;
            $date = $entry->pubDate;
            $description = '';

            if($eventsFeed){
                $description = explode(':',explode('<delim/>',html_entity_decode($entry->description))[0])[1]; // grabs date from description for events
            }else{
                $description = $entry->description;
            }

            $imageSrc = $entry->image;

            $arr = [
                'title' => $title,
                'link' => $link,
                'date' => strtotime($date),
                'description' => $description,
                'imageSrc' => $imageSrc,
            ];
            array_push($rssContent, $arr);
        }

        return $rssContent;

    }

}
