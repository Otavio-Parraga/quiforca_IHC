<?php
//create session
session_start();
$_SESSION['name'] = validateData($_POST['name']);
$_SESSION['userId'] = validateData($_POST['userId']);
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
$archive = fopen("../data/userData.xml", "w");
fwrite($archive, $xml->asXML());
fclose($archive);

//function to validate data
function validateData($data)
{
    return htmlspecialchars(stripcslashes(trim($data)));
}
