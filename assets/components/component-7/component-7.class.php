<?php

class EventDropdownFeed{

    public static function GetEvents($url){
        //edit
        $jsonURL = $url;
        
        $jsonEvent = file_get_contents($jsonURL);
        $jsonDecode = json_decode($jsonEvent, true);

        $eventsCounter = count($jsonDecode);

        $feed = array();



        foreach($jsonDecode as $key => $item){
            array_push($feed, $item);
        }

        return $feed;

        

    }
}
