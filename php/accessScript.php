<?php
session_start();
$archive = fopen("../data/test.txt", "a+");
fwrite($archive, "Nome: " . $_SESSION["name"] . "\n");
fwrite($archive, "Matricula: " . $_SESSION["userId"] . "\n");
fwrite($archive, "Desempenho: " . $_POST['trials'] . "\n");
fclose($archive);
