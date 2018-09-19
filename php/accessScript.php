<?php
session_start();
$archive = fopen("../data/test.txt", "a+");
fwrite($archive, "Esse foi mais um acesso de " . $_SESSION['name'] . "\n");
fwrite($archive, "Tempo gsto no objeto: " . $_POST['timeSpentOnObject']);
fclose($archive);
