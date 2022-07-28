<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
		<meta http-equiv="Pragma" content="no-cache"/>
		<meta http-equiv="Expires" content="0"/>
		<title>Payment</title>
		<link rel = "stylesheet" href = "../css/pay.css">
		<script src = "https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.js"></script>
		<script src = "../scripts/pay.js"></script>
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
			<form id = "payment-form" method = "POST" action = "store.php?p=s">
				<h1>Detalii plată</h1>
				<input id = "ccn" name = "ccn" type = "tel" placeholder = "xxxx xxxx xxxx xxxx">
				<input id = "exp" name = "exp" type = "month" placeholder = "LL/AA">
				<input id = "cvv" name = "cvv" type = "text" placeholder = "Cod CVV">
				<input id = "address1" name = "address1" type = "text" placeholder = "Addresa 1">
				<input id = "address2" name = "address2" type = "text" placeholder = "Addresa 2">
				<input id = "city" name = "city" type = "text" placeholder = "Oraș">
				<input id = "country" name = "country" type = "text" value = "România" disabled>
				<input id = "zip" name = "zip" type = "text" placeholder = "Cod poștal">
				<input id = "pay" name = "pay" type = "submit" value = "Plătește">
			</form>
			<div class = "info">
			</div>
		</div>
    </body>
</html>
