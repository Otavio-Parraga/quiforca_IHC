<?php
$archive = fopen("../data/test.txt", "a+");
fwrite($archive, "Esse foi mais um acesso de " . $_SESSION['name'] . "\n");
fwrite($archive, $_POST['test'] . "\n");
fclose($archive);
