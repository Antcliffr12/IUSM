<?php
if (isset($_GET)) {

    $startDate = $_GET['startDate'];

    $endDate = $_GET['endDate'];

    $selectUrl = $_GET['selectUrl'];

    $xmlURL = null;

    if($selectUrl == '' ){
      $xmlURL = 'https://uisapp2.iu.edu/ccl-prd/Xml.do?pubCalId=GRP21900&startDate='.$startDate.'&endDate='.$endDate.'&itemLimit=5';
    }

    $xmlEvent = simplexml_load_file($xmlURL);

    $eventsCounter = Count($xmlEvent->event);

    if($eventsCounter==0){
      $json_string = '0'; //zero means empty xml, this value has to be handle in jquery validation
    }else{
      $json_string = json_encode( $xmlEvent , JSON_HEX_QUOT | JSON_HEX_TAG |JSON_HEX_AMP | JSON_HEX_APOS | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_FORCE_OBJECT | JSON_PRESERVE_ZERO_FRACTION | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);

    }


    echo $json_string;



}


 ?>
