<?php
/*
-Inserir tentativas
-Limpar cache do auxData.xml
-Definir metodo para fazer a media de tempo total 
 */
$path = simplexml_load_file("../data/accessData.xml");
$xml = new SimpleXMLElement($path->asXML());
$pathAux = simplexml_load_file("../data/auxData.xml");
$xmlAux = new SimpleXMLElement($pathAux->asXML());
$userId = $_SESSION['userId'];
$timeOnObject = validateData($_POST['timeSpentOnObject']);
 
//set new access
$xml->addChild('acesso');
$nmrAcessos = $xml->count();

//set number of access
$xml->attributes()->nmrAcessos = $nmrAcessos;
$actualAccess = $xml->acesso[$nmrAcessos - 1];

//set the number of trials
$trials = $xmlAux->children();
foreach ($trials as $actualTrial) {
    $actualAccess->addChild($actualTrial);
}


//create access attributes
$actualAccess->addAttribute("idUsuario", $userId);
$actualAccess->addAttribute("tempoNoObjeto", $timeOnObject);



//save the file
$archive = fopen("../data/accessData.xml", "w");
fwrite($archive, $xml->asXML());
include "./objectScripts.php";
fclose($archive);


// print in the test file
//$archive = fopen("../data/test.txt", "a+");
//fwrite($archive, $trials);
//include "./objectScripts.php";
//fclose($archive);

//function to validate data
function validateData($data)
{
    return htmlspecialchars(stripcslashes(trim($data)));
}
?>