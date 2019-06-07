<!DOCTYPE html>
<html lang="pt-br">

<head>
	<title>QuiForca</title>
	<meta http-equiv="X-UA-Compatible" content="IE=9">
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/style.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
	<script id="ancora" src="js/script.js" class="object"></script>
	<script src="js/eventosclasses.js" class="object"></script>
	<script src="js/logica.js" defer class="object"></script>
	<script src="js/controle.js" defer class="object"></script>
	<script src="js/rest.js" defer class="object"></script>
	<!-- <script src="stats.js" defer class="object"></script> -->
	<script>
		window.sended = 0;
		window.trials = "";

		window.onbeforeunload = function(evt) {
			var message = "Ok";
			if (evt) {
				evt.returnValue = message;
			}
			if (sended == 0)
				return onClose();
		}

		//function to run when the user close the object
		function onClose() {
			if (window.sended == 0) {
				trialsToString();
				window.endDate = new Date();
				runAccessScript();
				runAnalytics();
				window.sended = 1;
				//window.location('final.html');
			}
		}

		function runAccessScript() {
			$.ajax({
				url: "./php/accessScript.php",
				type: "POST",
				data: "timeSpentOnObject=" + getDifferenceBetweenDates(window.beginDate, window.endDate),
				success: function(data) {
					console.log(data);
					runXmlController();
                    //runAnalytics();
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log(textStatus, errorThrown)
				}
			})
			console.log("Done first method");
		}

		function runXmlController() {
			$.ajax({
				url: "./php/xmlController.php",
				type: "POST",
				data: "",
				success: function(data) {
					console.log(data);
					//runAnalytics();
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log(textStatus, errorThrown)
				}
			})
			console.log("Done second method");
		}

		function runAnalytics() {
			$.ajax({
				url: "./php/analyticsScript.php",
				type: "POST",
				data: "",
				success: function(data) {
					console.log(data);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log(textStatus, errorThrown)
				}
			})
			console.log("Done third method");
		}

		//function to get how long someone stayed in the object
		function getDifferenceBetweenDates(fd, ld) {
			var difference = ld.getTime() - fd.getTime();
			var hours = Math.floor(difference / 36e5),
				minutes = Math.floor(difference % 36e5 / 60000),
				seconds = Math.floor(difference % 60000 / 1000);
			return hours + ":" + minutes + ":" + seconds;
		}

		function trialsToString() {
			for (var i = 0; i < window.tentativas.length; i++) {
				window.trials = window.trials + JSON.stringify(window.tentativas[i]);
			}
		}
	</script>

</body>

</html>