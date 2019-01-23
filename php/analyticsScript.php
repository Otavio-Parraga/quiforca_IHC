<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
$path = simplexml_load_file("../data/accessData.xml");
$xml = new SimpleXMLElement($path->asXML());
$total_time = "";
$avrg_time = "";
$avrg_questions = "";

//get all the times in the accessData xml
for ($i = 0; $i < $GLOBALS["xml"]->count(); $i++) {
    $total_time = $total_time . $GLOBALS["xml"]->acesso[$i]['tempoNoObjeto'] . "-";
    //echo var_dump($total_time);
}

//calls time_avrg and set the attribute mediaTempoTotalNoObjeto
$xml['mediaTempoTotalNoObjeto'] = time_avrg($total_time);

//calls get_avrg_trials and set the respective attribute
$xml['mediaTentativasPorUsuario'] = get_avrg_trials();

//calls get_avrg_questions and set the respective attribute
$xml['mediaAcertosPorUsuario'] = get_avrg_questions();
//method to get the average number of trials
function get_avrg_trials()
{
    $total_trials = 0;
    $total_access = $GLOBALS["xml"]->count();
    //echo $total_access;
    //"for" to run between the access
    for ($i = 0; $i < $total_access; $i++) {
        if (isset($GLOBALS["xml"]->acesso[$i]->tentativas)) {
            //echo "deu bom" . "\n";
            for ($j = 0; $j < $GLOBALS["xml"]->acesso[$i]->tentativas->children()->count(); $j++) {
                $total_trials++;
                //echo $total_trials . "\n";
            }
        }
    }
    return /* round */($total_trials / $total_access);
}
//method to get the average number of questions answered
function get_avrg_questions()
{
    $total_right_questions = 0;
    $total_access = $GLOBALS["xml"]->count();
    //echo $total_access;
    //"for" to run between the access
    for ($i = 0; $i < $total_access; $i++) {
        //if there are trials on that access
        if (isset($GLOBALS["xml"]->acesso[$i]->tentativas)) {
            //echo "deu bom" . "\n";
            for ($j = 0; $j < $GLOBALS["xml"]->acesso[$i]->tentativas->children()->count(); $j++) {
                foreach ($GLOBALS["xml"]->acesso[$i]->tentativas->tentativa[$j]->children() as $actual_question) {
                    if ($actual_question["concluida"] == "sim") {
                        $total_right_questions++;
                    }

                }
            }
        }
    }
    return /* round */($total_right_questions / $total_access);
}
//method to find the average time
function time_avrg($t)
{
    $aux;
    //split the string with the times
    $totalTime = new DateTime("00:00:00");
    $t = explode("-", $t);
    for ($i = 0; $i < sizeof($t) - 1; $i++) {
        $aux = explode(":", $t[$i]);
        $totalTime->add(new DateInterval("PT" . $aux[0] . "H" . $aux[1] . "M" . $aux[2] . "S"));
        //echo var_dump($totalTime);
    }
    //split the string totallTime into hours, minutes and seconds
    $totalTime = explode(":", $totalTime->format("H:i:s"));
    //echo var_dump($totalTime);
    $hours = (int) $totalTime[0];
    $minutes = (int) $totalTime[1];
    $seconds = (int) $totalTime[2];
    $totalSeconds = $hours * 3600 + $minutes * 60 + $seconds;
    //echo var_dump($totalSeconds);
    $time_avrg = $totalSeconds / count($GLOBALS["xml"]->children());
    //echo var_dump($time_avrg);
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

$_SESSION['logged'] = 0;
session_abort();

