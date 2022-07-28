<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
		<meta http-equiv="Pragma" content="no-cache"/>
		<meta http-equiv="Expires" content="0"/>
		<title>Contact TruckDealz</title>
		<link rel = "stylesheet" href = "../css/contact.css">
		<link rel="icon" type="image/png" href="../images/favicons/logo16x16.png" sizes="16x16">
		<link rel="icon" type="image/png" href="../images/favicons/logo32x32.png" sizes="32x32">
		<link rel="icon" type="image/png" href="../images/favicons/logo64x64.png" sizes="64x64">
		<link rel="icon" type="image/png" href="../images/favicons/logo128x128.png" sizes="128x128">
	</head>
	<body>
		<div class = "header">
			<img src = "../images/contact/logo.png" id = "logo_icon">
			<h1>TruckDealz</h1>
			<a id = "main_page" href = "main_page.php"></a>
		</div>
			<div class = "content">
			<div class = "table">
				<div class = "table-header">
					<div class = "h-telefon">Telefon</div>
					<div class = "h-adresa">Adresa</div>
					<div class = "h-fb">Facebook</div>
					<div class = "h-ig">Instagram</div>
				</div>
				<div class = "table-body">
					<div class = "b-telefon">0762398431</div>
					<div class = "b-adresa">Sanyo Lamar Anders, str Roşilor, nr 4</div>
					<div class = "b-fb">@truck.dealz.1</div>
					<div class = "b-ig">@TruckDealz</div>
				</div>
			</div>
		<div>
		<?php
			if(!extension_loaded("gd"))
				echo '<script>
			console.warn("Librăria '."'gd'".' nu a fost încărcată. Dacă sunteţi administratorul site-ului asiguraţi-vă că aţi activat librăria '."'gd'".' în fişierul de configurare al php!");
		</script>
';
		?>
	</body>
</html>