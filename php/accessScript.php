<?php
/*
-Definir metodo para criar uma nova tetativa
    Lembrar que a primeira não conta, no caso a da posição 0
-Definir metodo para criar uma nova questao
-Definir metodo para inserir os atributos do acesso
-Definir metodo para fazer a media de tempo total
 */
$path = simplexml_load_file("../data/accessData.xml");
$xml = new SimpleXMLElement($path->asXML());
$userId = $_SESSION['userId'];
$timeOnObject = validateData($_POST['timeSpentOnObject']);
$trials = $_POST['trials'];
$numberOfTrials = $_POST['numberOfTrials'];
 
//set new access
$xml->addChild('acesso');
$nmrAcessos = $xml->count();

//set number of access
$xml->attributes()->nmrAcessos = $nmrAcessos;
$actualAccess = $xml->acesso[$nmrAcessos - 1];

//set the number of trials


//create access attributes
$actualAccess->addAttribute("idUsuario", $userId);
$actualAccess->addAttribute("tempoNoObjeto", $timeOnObject);

//save the file
$archive = fopen("../data/accessData.xml", "w");
fwrite($archive, $xml->asXML());
include "./objectScripts.php";
fclose($archive);


// print in the test file
$archive = fopen("../data/test.txt", "a+");
fwrite($archive, $trials);
include "./objectScripts.php";
fclose($archive);

//function to validate data
function validateData($data)
{
    return htmlspecialchars(stripcslashes(trim($data)));
}
?>