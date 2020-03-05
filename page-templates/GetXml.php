<?php
/*
Template Name: GET XML
*/
//connects to Database Wordpress

global $wpdb;
$table_name = $wpdb->prefix . 'markers';

$doc = new DomDocument("1.0", "UTF-8");
$node = $doc->createElement("markers");
$parnode  = $doc->appendChild($node);

$query = $wpdb->get_results("SELECT * FROM $table_name");
header("Content-type: text/xml");

foreach($query as $item){
  $node = $doc->createElement("marker");
  $newnode = $parnode->appendChild($node);

  $newnode->setAttribute("id", $item->id);
  $newnode->setAttribute("contactname", $item->contactname);
  $newnode->setAttribute("address", $item->address);
  $newnode->setAttribute("program_name", $item->program_name);
  $newnode->setAttribute("specialty", $item->specialty);
  $newnode->setAttribute("transitionyear", $item->transitionyear);
}

$xmlfile = $doc->saveXML();
$doc->save('test.xml');
echo $xmlfile;













?>
