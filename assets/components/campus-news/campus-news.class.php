<?php
class CampusNewsFeed {

  public static function GetFeed($campus){

    if(!empty($campus)){
      $rss = new DOMDocument();
      $rss->loadXML(file_get_contents($campus));
      $feed = array();

      // All Items will have an dc:creator. Therefore count will be the same.
      $creator = $rss->getElementsByTagNameNS('http://purl.org/dc/elements/1.1/', 'creator');
      $creatorCount = $creator->length;
      $creatorArray = [];

      if ($creatorCount != 0) {
          for ($i = 0; $i <= $creatorCount - 1; $i++) {

              $createArray[$i] = $creator->item($i)->textContent;
          }
      }


      foreach ($rss->getElementsByTagName('item') as $itemKey => $node) {


        $item = [
          'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
          'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
          'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
          'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
          'author' => isset($createArray[$itemKey]) ? $createArray[$itemKey] : '',

        ];
        array_push($feed, $item);
      }

      return $feed;
    }else{
      return '';
    }
  }
}

?>
