<?php
if (isset($_GET)) {

class EventFeed{


    public static function GetFeed($url, $startDate){


      $urlString = null;
      $pubCalId = substr(strstr($url, '='),1,8);
      $endDate = date('Y-m-d', strtotime('12/31'));

      $urlString = "https://uisapp2.iu.edu/ccl-prd/Xml.do?pubCalId=".$pubCalId."&startDate=".$startDate."&endDate=".$endDate."";

      $xmlData = simplexml_load_file($urlString);

      $eventsCounter = Count($xmlData->event);
      
      $devices = array();
      foreach($xmlData->event as $item)
      {
        $dc = $item->children('http://purl.org/dc/elements/1.1/');
         $device = array();

         foreach($item as $key => $value)
         {
              $device[(string)$key] = (string)$value;
         }

         foreach($dc as $key => $value)
         {
              $device[(string)$key] = (string)$value;
         }

         $devices[] = $device;
      }
      return $devices;
    }


  }
}
