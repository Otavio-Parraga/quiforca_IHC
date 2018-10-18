<?php
$path = simplexml_load_file("../data/auxData.xml");
$xml = new SimpleXMLElement($path->asXML());

//create question
$nmrQuestoes = $xml->count();
$xml->addChild("tentativa");


$archive = fopen("../data/auxData.xml", "w");
fwrite($archive, $xml->asXML());
fclose($archive);
?>