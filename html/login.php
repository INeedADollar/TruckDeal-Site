<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
		<meta http-equiv="Pragma" content="no-cache"/>
		<meta http-equiv="Expires" content="0"/>
		<title>Autentificare</title>
		<link rel = "stylesheet" href = "../css/login.css">
		<script src = "../scripts/login.js"></script>
		<link rel="icon" type="image/png" href="../images/favicons/logo16x16.png" sizes="16x16">
		<link rel="icon" type="image/png" href="../images/favicons/logo32x32.png" sizes="32x32">
		<link rel="icon" type="image/png" href="../images/favicons/logo64x64.png" sizes="64x64">
		<link rel="icon" type="image/png" href="../images/favicons/logo128x128.png" sizes="128x128">
	</head>
	<body>
		<div class = "header">
			<img src = "../images/login/logo.png" id = "logo_icon">
			<h1>TruckDealz</h1>
			<a id = "main_page" href = "main_page.php"></a>
		</div>
		<div class = "form-view">
			<form id = "log-in">
				<h1>AUTENTIFICARE</h1>
				<input type = "text" name = "email" class = "email" placeholder = "email" spellcheck = "false">
				<input type = "password" name = "password" class = "password" placeholder = "parolă" spellcheck = "false">
				<p class = "wrong-input"></p>
				<p>Nu aveţi cont? <a id = "up-link">Creaţi unul!</a></p>
				<button id = "sign-in-button" type = "button">Autentificare</button>
			</form>
			<form id = "sign-up">
				<h1>CREARE CONT</h1>
				<input type = "text" name = "email" class = "email" placeholder = "email" spellcheck = "false">
				<input type = "password" name = "password" class = "password" placeholder = "parolă" spellcheck = "false">
				<input type = "password" name = "confirm-password" class = "password" placeholder = "confirmare parolă" spellcheck = "false">
				<p class = "wrong-input"></p>
				<p>Aveţi cont? <a id = "in-link">Conectaţi-vă!</a></p>
				<button id = "sign-up-button" type = "button">Crează cont</button>
			</form>
		</div>
		<?php
			if(!extension_loaded("gd"))
				echo '<script>
			console.warn("Librăria '."'gd'".' nu a fost încărcată. Dacă sunteţi administratorul site-ului asiguraţi-vă că aţi activat librăria '."'gd'".' în fişierul de configurare al php!");
		</script>
';
		?>
	</body>
</html>