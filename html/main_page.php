<?php
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
		<meta http-equiv="Pragma" content="no-cache"/>
		<meta http-equiv="Expires" content="0"/>
		<title>TruckDeal</title>
		<link rel = "stylesheet" href = "../css/main_page.css">
		<script src = "../scripts/main_page.js"></script>
		<link rel="icon" type="image/png" href="../images/favicons/logo16x16.png" sizes="16x16">
		<link rel="icon" type="image/png" href="../images/favicons/logo32x32.png" sizes="32x32">
		<link rel="icon" type="image/png" href="../images/favicons/logo64x64.png" sizes="64x64">
		<link rel="icon" type="image/png" href="../images/favicons/logo128x128.png" sizes="128x128">
	</head>
	<body>
		<div class = "header">
			<img src = "../images/main_page/logo.png" id = "logo_icon">
			<h1>TruckDeal</h1>
			<a id = "main_page" href = "main_page.php"></a>
			 <?php
				if (array_key_exists("loggedin", $_SESSION) && $_SESSION['loggedin'] == true){
					$user_icon = "../images/user_icons/icon-fallback.png";
					if(array_key_exists("id", $_SESSION)) {
						$user_icon = "../images/user_icons/".$_SESSION['id'].".png";
						if(!is_readable($user_icon))
							$user_icon = "../images/user_icons/icon-fallback.png";
					}
					
					echo "<div class = 'user'>
							<button id = 'user' style = 'background-image: url(".$user_icon.")'></button>
							<div class = 'drop-down'>
								<p>".$_SESSION['email']."</p>
								<p id = 'logout'><img src = '../images/main_page/logout.png'>Deconectare</p>
							</div>
						</div>";
				}
				else 
					echo "<button id = 'aut'></button>
						<a id = 'login' href = 'login.php?l=m'>Autentificare</a>";
					
			?>
		</div>
		<div class = "main-view">
			<div class = "card">
				<div class = "backgr"></div>
				<div class = "content">
					<h3>Magazin online</h3>
					<p>Vizitaţi noul nostru magazin online
					chiar acum şi vedeţi ofertele de actualitate
					la cele mai noi camioane!</p>
					<a href = "store.php">Magazin</a>
				</div>
			</div>
			<div class = "card">
				<div class = "backgr"></div>
				<div class = "content">
					<h3>Despre noi</h3>
					<p>Suntem o companie care încearcă să
					aducă o schimbare în ceea ce înseamnă achiziţionarea
					de camioane.</p>
					<a href = "about.php">Citeşte mai multe</a>
				</div>
			</div>
			<div class = "card">
				<div class = "backgr"></div>
				<div class = "content">
					<h3>Contact</h3>
					<p>Aflaţi unde ne puteţi găsi sau cum să
					intraţi în legatură cu noi pentru a primi informaţii
					sau a discuta oportunităţi de afaceri.</p>
					<a href = "contact.php">Date contact</a>
				</div>
			</div>
		</div>
		<footer>
			<p>© 2021 TruckDeal Company</p>
		</footer>
		<?php
			if(!extension_loaded("gd"))
				echo '<script>
			console.warn("Librăria '."'gd'".' nu a fost încărcată. Dacă sunteţi administratorul site-ului asiguraţi-vă că aţi activat librăria '."'gd'".' în fişierul de configurare al php!");
		</script>
';
		?>
	</body>
</html>