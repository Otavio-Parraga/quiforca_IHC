<?php
$path = simplexml_load_file("../data/accessData.xml");
$xml = new SimpleXMLElement($path->asXML());
$pathAux = simplexml_load_file("../data/auxData.xml");
$xmlAux = new SimpleXMLElement($pathAux->asXML());

//create de aux tag in the beggining of the last access
$xml->acesso[$xml->count() - 1]->addChild("aux");

//clear the empty trials
for ($i = 0; $i < $xmlAux->count(); $i++) {
    if (!isset($xmlAux->tentativa[$i]->questao)) {
        unset($xmlAux->tentativa[$i]);
    }
}
for ($i = 0; $i < $xmlAux->count(); $i++) {
    if ($xmlAux->tentativa[$i]->count() == 0) {
        unset($xmlAux->tentativa[$i]);
    }
}


//calls the method to insert one xml file inside the other
simplexml_insert_after($xmlAux, $xml->acesso[$xml->count() - 1]->aux);


//deletes the aux tag
unset($xml->acesso[$xml->count() - 1]->aux);

//clear the auxiliar xml file
for ($i = 0; $i < $xmlAux->count(); $i++) {
    unset($xmlAux->tentativa[$i]);
}
for ($i = 0; $i < $xmlAux->count(); $i++) {
    unset($xmlAux->tentativa[$i]);
}



// print in the test file
$archive = fopen("../data/accessData.xml", "w");
$djMarquinhos = fopen("../data/auxData.xml", "w");
fwrite($archive, $xml->saveXML());
fwrite($djMarquinhos, $xmlAux->saveXML());
//fwrite($archive, $xml);
fclose($archive);
fclose($djMarquinhos);


//method to insert an xml node above another
function simplexml_insert_after(SimpleXMLElement $insert, SimpleXMLElement $target)
{
    $target_dom = dom_import_simplexml($target);
    $insert_dom = $target_dom->ownerDocument->importNode(dom_import_simplexml($insert), true);
    if ($target_dom->nextSibling) {
        return $target_dom->parentNode->insertBefore($insert_dom, $target_dom->nextSibling);
    } else {
        return $target_dom->parentNode->appendChild($insert_dom);
    }
}
?>
