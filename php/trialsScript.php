<?php
session_start();
$userId = $_SESSION['userId'];
$path = simplexml_load_file("../data/$userId.xml");
$xml = new SimpleXMLElement($path->asXML());

//create question
$nmrQuestoes = $xml->count();
$xml->addChild("tentativa");


$archive = fopen("../data/$userId.xml", "w");
fwrite($archive, $xml->asXML());
fclose($archive);
