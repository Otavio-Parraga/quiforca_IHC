<?php
session_start();
$userId = $_SESSION['userId'];
$path = simplexml_load_file("../data/$userId.xml");
$xml = new SimpleXMLElement($path->asXML());
$dica = $_POST['dica'];
$palavra = $_POST['palavra'];

//create question
$nmrTentativas = $xml->count();
$xml->tentativa[$nmrTentativas -1]->addChild('questao');
$nmrQuestoes= $xml->tentativa[$nmrTentativas -1]->count();
$xml->tentativa[$nmrTentativas -1]->questao[$nmrQuestoes-1]->addChild("dica", $dica);
$xml->tentativa[$nmrTentativas -1]->questao[$nmrQuestoes-1]->addChild("palavra", $palavra);
$xml->tentativa[$nmrTentativas -1]->questao[$nmrQuestoes-1]->addAttribute("concluida", "nao");


$archive = fopen("../data/$userId.xml", "w");
fwrite($archive, $xml->asXML());
fclose($archive);
?>