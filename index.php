<?php
session_start();

if ($_SESSION['logged'] == 1) {
    header('Location: http://learninganalyticsphp/quiforca_IHC/erro.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<!--TO DO LIST:
[] Colocar os campos para preenchimento de dados do usuário
[] Deixar a página bonitinha
[] Enviar dados do usuário para o indexScript.php
[] Enviar horário de início para indexScript.php
[] Ao final, redirecionar para a página object.html
-->

<head>
    <title>QuiForca</title>
    <meta http-equiv="X-UA-Compatible" content="IE=9">
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/theme.css">
    <script src="js/jquery-1.8.1.js"></script>
</head>

<body>
    <div class="form-style-6">
        <form action="object.html">
            <input type="text" placeholder="Nome" id="name" />
            <input type="text" placeholder="Matricula" id="userId" />
            <br>
            <input type="submit" value="Enviar" id="sendUserData">
        </form>
    </div>

    <script>
        $("#sendUserData").click(function () {
            catchUserData();
            sendUserData();
        })

        function catchUserData() {
            window.name = document.getElementById('name').value;
            window.userId = document.getElementById('userId').value;
            console.log(window.name + " " + window.userId);
        }

        function sendUserData() {
            $.ajax({
                url: "php/indexScript.php",
                type: "POST",
                data: "name=" + window.name + "&userId=" + window.userId,
                success: function (data) {
                    console.log(data);
                }, error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown)
                }
            })
        }
    </script>

</body>

</html>