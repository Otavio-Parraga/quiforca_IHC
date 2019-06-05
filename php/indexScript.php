<?php
//-------------------------SCRIPT TO CREATE THE USERS'S DATA
session_start(); 
$_SESSION['name'] = validateData($_POST['name']);
$_SESSION['userId'] = validateData($_POST['userId']);
$userId = $_SESSION['userId'];
$path = simplexml_load_file("../data/userData.xml");
$xml = new SimpleXMLElement($path->asXML());

//IF THE USER ALREADY HAVE AN ACCOUNT
$actualUser = null;
foreach ($xml->children() as $user) {
    if ($user["id"] == $_SESSION['userId']) {
        $user["nmrDeAcessos"] = $user["nmrDeAcessos"] + 1;
        $actualUser = $user;
        break;
    }
}

if ($actualUser == null) {
//IF THE USER DO NOT HAVE AN ACCOUNT
    $xml->addChild("usuario", "\n");
    $numberOfTheBeast = $xml->count();
    $xml->attributes()->nmrDeUsuarios = $numberOfTheBeast;
    $xml->usuario[$numberOfTheBeast - 1]->addAttribute("id", $_SESSION['userId']);
    $xml->usuario[$numberOfTheBeast - 1]->addAttribute("nome", $_SESSION['name']);
    $xml->usuario[$numberOfTheBeast - 1]->addAttribute("nmrDeAcessos", 1);
}

//create user file to save his data
$userFile = fopen("../data/$userId.xml", "w");
fwrite($userFile, '<?xml version="1.0" encoding="UTF-8"?>');
fwrite($userFile, '<tentativas>
</tentativas>');
//fwrite($userFile, "\n");
//fwrite($userFile,'<acesso idUsuario="');
//fwrite($userFile,$userId);
//fwrite($userFile, '" tempoNoObjeto="">');
//fwrite($userFile, "\n");
//fwrite($userFile, '</acesso>');
fclose($userFile);

$archive = fopen("../data/userData.xml", "w");
fwrite($archive, $xml->asXML());
fclose($archive);

//function to validate data
function validateData($data)
{
    return htmlspecialchars(stripcslashes(trim($data)));
}
