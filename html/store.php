<?php
	require "../php_scripts/database_scripts/database_functions.php";
	require "../php_scripts/environment/env_read.php";
	
	function get_trucks() {
		$env_variables = get_variables();
		$sql_query_trucks = "SELECT * FROM ".$env_variables['TRUCKS_TABLE'];
		
		return get_all_entries_from_database_table($env_variables, 
			$env_variables["TRUCKS_DATABASE"], $sql_query_trucks);
	}
	
	function search_trucks($search_query) {
		$env_variables = get_variables();
		$sql_query_trucks = "SELECT * FROM ".$env_variables['TRUCKS_TABLE']
			." WHERE Truck_Name_Trim LIKE '%".preg_replace('/[\W]/', '', $search_query)."%'";
		
		return get_all_entries_from_database_table($env_variables, 
			$env_variables["TRUCKS_DATABASE"], $sql_query_trucks);
	}
	
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
		<title>Magazin Truck Deal</title>
		<link rel = "stylesheet" href = "../css/store.css">
		<script src = "https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script src = "../scripts/store.js"></script>
		<link rel="icon" type="image/png" href="../images/favicons/logo16x16.png" sizes="16x16">
		<link rel="icon" type="image/png" href="../images/favicons/logo32x32.png" sizes="32x32">
		<link rel="icon" type="image/png" href="../images/favicons/logo64x64.png" sizes="64x64">
		<link rel="icon" type="image/png" href="../images/favicons/logo128x128.png" sizes="128x128">
	</head>
	<body>
		<div class = "header">
			<img src = "../images/store/logo.png" id = "logo_icon">
			<h1>TruckDealz</h1>
			<a id = "main_page" href = "main_page.php"></a>
			<button type = "button" class = "search-button"></button>
			<div class = "search">
				<input type = "text" spellcheck="false" id = "sb"><button type = "button" id = "si"></button>
			</div>
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
								<p id = 'wtrucks' class = 'drop-down-item'><img src = '../images/store/wtrucks-logo.png'>Camioane în așteptare</p>
								<p id = 'logout' class = 'drop-down-item'><img src = '../images/main_page/logout.png'>Deconectare</p>
							</div>
						</div>";
				}
				else {
					echo "<button id = 'aut'></button>";
									
					if(array_key_exists('q', $_GET) && $_GET['q'] != "")
						echo "<a id = 'login' href = 'login.php?l=s&q=".$_GET['q']."'>Autentificare</a>";
					else
						echo "<a id = 'login' href = 'login.php?l=s'>Autentificare</a>";
				}
					
			?>
		</div>
		<?php
			if(array_key_exists('q', $_GET) && $_GET['q'] != "") {
				$trucks = search_trucks($_GET['q']);
				echo "<div class = 'content' style = 'height: 79vh; margin-top: 11vh;'>
					<a id = 'back' href = 'store.php'><img src = '../images/store/back.png'></a>
					<h1 id = 'sres'>Rezultatele căutării</h1>
				";
			}
			else {
				$trucks = get_trucks();
				echo "<div class = 'content' style = 'height: 80vh; margin-top: 7vh;'>";
			}
			
				if(is_array($trucks) && !empty($trucks)) {
					foreach($trucks as $truck_entry) {
						echo "<div class = 'item'>";
						if($truck_entry['Free_Transport'])
							echo "<div class='transport-tag'>Transport gratuit</div>
								<div class='transport-tag-l'></div>
								<div class='transport-tag-r'></div>
								";
								
						echo "<img src = '../images/store/trucks/".$truck_entry['Image_Name']."'>
							<h1>".$truck_entry['Truck_Name']."</h1>
							<p class = 'old-price'>".$truck_entry['Old_Price']."€</p>
							<p class = 'new-price'>".$truck_entry['New_Price']."€</p>
							<button type = 'button'>Rezervă camion</button>
						</div>";
					}
				}	
			?>
		</div>
		<div class = "modal">
			<div class = "dialog">
				<p>Camionul a fost adaugat în lista de așteptare!</p>
				<button type = "button" class = "ok-btn">Ok</button>
			</div>
		</div>
		<div class = "modal">
			<div class = "dialog">
				<p>Plata a fost realizată cu succes!</p>
				<button type = "button" class = "ok-btn">Ok</button>
			</div>
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