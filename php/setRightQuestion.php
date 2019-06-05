<?php
session_start();
$userId = $_SESSION['userId'];
$path = simplexml_load_file("../data/$userId.xml");
$xml = new SimpleXMLElement($path->asXML());

$nmrTentativas = $xml->count();
$nmrQuestoes = $xml->tentativa[$nmrTentativas - 1]->count();
$xml->tentativa[$nmrTentativas - 1]->questao[$nmrQuestoes - 1]["concluida"] = "sim";

$archive = fopen("../data/$userId.xml", "w");
fwrite($archive, $xml->asXML());
fclose($archive);
