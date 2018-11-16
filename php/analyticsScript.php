<?php
$path = simplexml_load_file("../data/accessData.xml");
$xml = new SimpleXMLElement($path->asXML());
$total_time = "";

//get all the times in the accessData xml
for ($i = 0; $i < $GLOBALS["xml"]->count(); $i++) {
    $total_time = $total_time . $GLOBALS["xml"]->acesso[$i]['tempoNoObjeto'] . "-";
    echo var_dump($total_time);
}

//calls time_avrg and set the attribute mediaTempoTotalNoObjeto
$xml['mediaTempoTotalNoObjeto'] = time_avrg($total_time);


function time_avrg($t)
{
    $aux;
    $totalTime = new DateTime("00:00:00");
    $t = explode("-", $t);
    for ($i = 0; $i < sizeof($t) - 1; $i++) {
        $aux = explode(":", $t[$i]);
        $totalTime->add(new DateInterval("PT" . $aux[0] . "H" . $aux[1] . "M" . $aux[2] . "S"));
        echo var_dump($totalTime);
    }
    $totalTime = explode(":", $totalTime->format("H:i:s"));
    echo var_dump($totalTime);
    $hours = (int)$totalTime[0];
    $minutes = (int)$totalTime[1];
    $seconds = (int)$totalTime[2];
    $totalSeconds = $hours * 3600 + $minutes * 60 + $seconds;
    echo var_dump($totalSeconds);
    $time_avrg = $totalSeconds / count($GLOBALS["xml"]->children());
    echo var_dump($time_avrg);
    $finalHour = 0;
    $finalMinute = 0;
    $finalSecond = 0;
    if ($time_avrg > 3599) {
        $finalHour = floor($time_avrg / 3600);
        $time_avrg = $finalHour * 3600;
    }
    if ($time_avrg > 59) {
        $finalMinute = floor($time_avrg / 60);
        $time_avrg = floor($time_avrg / 60);
    }
    $finalSecond = $time_avrg;
    return $finalHour . ":" . $finalMinute . ":" . round($finalSecond);

}

$archive = fopen("../data/accessData.xml", "w");
fwrite($archive, $xml->saveXML());
fclose($archive);
?>