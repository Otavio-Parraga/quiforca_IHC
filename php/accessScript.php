<?php
session_start(); 
$userId = $_SESSION['userId'];

$path = simplexml_load_file("../data/accessData.xml");
$xml = new SimpleXMLElement($path->asXML());
$timeOnObject = validateData($_POST['timeSpentOnObject']);

if (validateTimeOnObject()) {
//set new access
    $xml->addChild('acesso');
    $nmrAcessos = $xml->count();

//set number of the access
    $xml->attributes()->nmrAcessos = $nmrAcessos;
    $actualAccess = $xml->acesso[$nmrAcessos - 1];


//create access attributes
    $actualAccess->addAttribute("idUsuario", $userId);
    $actualAccess->addAttribute("tempoNoObjeto", $timeOnObject);



//save the file
    $archive = fopen("../data/accessData.xml", "w");
    fwrite($archive, $xml->asXML());
    //include "./objectScripts.php";
    fclose($archive);
} else {
    exit();
}

//function to validate data
function validateData($data)
{
    return htmlspecialchars(stripcslashes(trim($data)));
}
//function to validate the time spent on object variable
function validateTimeOnObject()
{
    for ($i = 0; $i < 11; $i++) {
        if ($GLOBALS['timeOnObject'] == "0:0:$i") {
            return false;
        }
    }
    return true;
}
?>