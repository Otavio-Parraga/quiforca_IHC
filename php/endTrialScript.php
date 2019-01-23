<?php
$path = simplexml_load_file("../data/auxData.xml");
$xml = new SimpleXMLElement($path->asXML());

//create question
$nmrTentativas = $xml->count();
$nmrQuestoes = $xml->tentativa[$nmrTentativas - 1]->count();
$xml->tentativa[$nmrTentativas - 1]->questao[$nmrQuestoes - 1]["concluida"] = "nao";


$archive = fopen("../data/auxData.xml", "w");
fwrite($archive, $xml->asXML());
fclose($archive);
?>