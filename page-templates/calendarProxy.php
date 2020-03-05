<?php
if (isset($_GET)) {


  $jsonURL = 'https://events.iu.edu/live/json/events/group_id/9/tag_id/null';

  $jsonEvent = file_get_contents($jsonURL);
  $jsonDecode = json_decode($jsonEvent, true);
  $eventsCounter = count($jsonDecode);
  //encode for array conversion
    echo json_encode($jsonDecode);


}


 ?>
