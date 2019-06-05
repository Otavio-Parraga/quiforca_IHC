<!DOCTYPE html>
<html lang="pt-br">

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
        <form action="object.php">
            <input type="text" placeholder="Nome" id="name" />
            <input type="text" placeholder="Matricula" id="userId" />
            <br>
            <input type="submit" value="Enviar" id="sendUserData" onClick="return validate()">
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

        function validate(){
            if(document.getElementById("name").value == ""){
                alert("Insira um nome válido!");
                return false;
            } 
            if (document.getElementById("userId").value== ""){
                alert("Insira uma matrícula válida!");
                return false;
            }
        }
    </script>

</body>

</html>
