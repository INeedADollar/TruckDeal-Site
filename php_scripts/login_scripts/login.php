<?php
	require "user_account_create.php";
	require "user_icon_creation.php";
	
	abstract class FormDataStatus {
		const INVALID_ACCESS = 0;
		const INVALID_EMAIL = 1;
		const INVALID_PASSWORD = 2;
		
		const EMAIL_NULL = 3;
		const PASSWORD_NULL = 4;
		const CONFIRM_PASSWORD_NULL = 5;
		
		const PASSWORDS_NOT_MATCH = 6;
		
		const SUCCESS_ACCESS_PERMITED = 7;
		const ERROR_ACCESS_DENIED = 8;
	}
	
	function check_if_user_data_exists($user_data, $credentials) {
		$sql_select = "SELECT * FROM ".$credentials["USERS_TABLE"]." WHERE email='"
			.$user_data['email']."' AND password='".$user_data['password']."';";
		$user_entries = get_all_entries_from_database_table($credentials, 
			$credentials["USERS_DATABASE"], $sql_select);

		return $user_entries && is_array($user_entries);
	}
	
	function check_request_data() {
		if(array_key_exists("login", $_POST)) {
			if(!array_key_exists("email", $_POST) ||
				!array_key_exists("password", $_POST))
				return FormDataStatus::INVALID_ACCESS;
				
			if($_POST['email'] == "")
				return FormDataStatus::EMAIL_NULL;
			
			if($_POST['password'] == "")
				return FormDataStatus::PASSWORD_NULL;
			
			return FormDataStatus::SUCCESS_ACCESS_PERMITED;
		}
		else if(array_key_exists("sign-up", $_POST)) {
			if(!array_key_exists("email", $_POST) ||
				!array_key_exists("password", $_POST) ||
				  !array_key_exists("confirm-password", $_POST))
				return FormDataStatus::INVALID_ACCESS;
			
			if($_POST['email'] == "")
				return FormDataStatus::EMAIL_NULL;
			
			if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
				return FormDataStatus::INVALID_EMAIL;
			
			if($_POST['password'] == "")
				return FormDataStatus::PASSWORD_NULL;

			if(strlen($_POST['password']) < 8)
				return FormDataStatus::INVALID_PASSWORD;	
			
			if($_POST['confirm-password'] == "")
				return FormDataStatus::CONFIRM_PASSWORD_NULL;
			
			if($_POST['password'] != $_POST['confirm-password'])
				return FormDataStatus::PASSWORDS_NOT_MATCH;
				
			return FormDataStatus::SUCCESS_ACCESS_PERMITED;
		}
		else
			return FormDataStatus::INVALID_ACCESS;
	}
	
	function parse_request_data_status() {
		$login_email_border_color = "black\n";
		$login_password_border_color = "black\n";
		$login_warning = "\n";
		$login_form_visibility = "visible\n";
		
		$sign_up_email_border_color = "black\n";
		$sign_up_password_border_color = "black\n";
		$sign_up_confirm_password_border_color = "black\n";
		$sign_up_warning = "\n";
		$sign_up_form_visibility = "hidden\n";

		$result = check_request_data();
		
		if($result != FormDataStatus::INVALID_ACCESS) {
			if(array_key_exists("login", $_POST)) {
				if($result == FormDataStatus::EMAIL_NULL) {
					$login_email_border_color = "red\n";
					$login_warning = "Emailul nu poate fi necompletat!\n";
				}
				
				if($result == FormDataStatus::PASSWORD_NULL) {
					$login_password_border_color = "red\n";
					$login_warning = "Parola nu poate fi necompletată!\n";
				}
				
				if($result == FormDataStatus::ERROR_ACCESS_DENIED) {
					$login_email_border_color = "red\n";
					$login_password_border_color = "red\n";
					$login_warning = "Email sau parolă invalide!\n";
				}
				
				if($result == FormDataStatus::SUCCESS_ACCESS_PERMITED) {
					$user_data = array(
						"email" => $_POST['email'],
						"password" => $_POST['password']
					);
					
					$env_variables = get_variables();
					if(check_if_user_data_exists($user_data, $env_variables)) {
						$env_variables = get_variables();
						$sql_query_id = "SELECT id FROM ".$env_variables['USERS_TABLE']." WHERE email='"
							.$_POST['email']."';";
						$query_result = get_all_entries_from_database_table($env_variables, $env_variables['USERS_DATABASE'], $sql_query_id);
						
						session_start();
						$_SESSION['loggedin'] = true;
						$_SESSION['email'] = $_POST['email'];
						
						if(!empty($query_result))
							$_SESSION['id'] = $query_result[0]['id'];
						
						if(array_key_exists("l", $_GET)) {
							if($_GET['l'] == "m")
								return "main_page.php";
							
							if($_GET['l'] == "s") {
								if(array_key_exists("q", $_GET)){
									if(array_key_exists("d", $_GET))
										return "store.php?q=".$_GET['q']."&d=t";
									
									return "store.php?q=".$_GET['q'];
								}
								
								if(array_key_exists("d", $_GET))
									return "store.php?d=t";
									
								return "store.php";
							}
						}
					}
					
					$login_warning = "Email sau parolă invalide!\n";
				}
			}
			
			if(array_key_exists("sign-up", $_POST)) {
				$login_form_visibility = "hidden\n";
				$sign_up_form_visibility = "visible\n";
				
				if($result == FormDataStatus::EMAIL_NULL) {
					$sign_up_email_border_color = "red\n";
					$sign_up_warning = "Emailul nu poate fi necompletat!\n";
				}
				
				if($result == FormDataStatus::PASSWORD_NULL) {
					$sign_up_password_border_color = "red\n";
					$sign_up_warning = "Parola nu poate fi necompletată!\n";
				}
				
				if($result == FormDataStatus::INVALID_EMAIL) {
					$sign_up_email_border_color = "red\n";
					$sign_up_warning = "Email invalid!\n";
				}
				
				if($result == FormDataStatus::INVALID_PASSWORD) {
					$sign_up_password_border_color = "red\n";
					$sign_up_warning = "Parola trebuie să aibă minim 8 caractere!\n";
				}
				
				if($result == FormDataStatus::CONFIRM_PASSWORD_NULL) {
					$sign_up_password_border_color = "red\n";
					$sign_up_confirm_password_border_color = "red\n";
					$sign_up_warning = "Parola trebuie confirmată!\n";
				}
				
				if($result == FormDataStatus::PASSWORDS_NOT_MATCH) {
					$sign_up_password_border_color = " red\n";
					$sign_up_confirm_password_border_color = "red\n";
					$sign_up_warning = "Parolele nu se potrivesc!\n";
				}
				
					
				if($result == FormDataStatus::SUCCESS_ACCESS_PERMITED) {
					$user_data = array(
						"email" => $_POST['email'],
						"password" => $_POST['password']
					);
					
					$create_user_result = create_new_user($user_data);
					if(!$create_user_result)
						$sign_up_warning = "Contul nu a putut fi creat.<br>Încercaţi din nou mai tarziu!\n";
					else if($create_user_result == ERROR_USER_EXISTS)
						$sign_up_warning = "Cont deja existent!\n";
					else {
						$env_variables = get_variables();
						$sql_query_id = "SELECT id FROM ".$env_variables['USERS_TABLE']." WHERE email='"
							.$_POST['email']."';";
						$query_result = get_all_entries_from_database_table($env_variables, $env_variables['USERS_DATABASE'], $sql_query_id);

						session_start();
						$_SESSION['loggedin'] = true;
						$_SESSION['email'] = $_POST['email'];
						
						if(!empty($query_result)) {
							$file_name = "../../images/user_icons/".$query_result[0]['id'].".png";
							generate_user_icon(strtoupper($_POST['email'][0]), $file_name);
							$_SESSION['id'] = $query_result[0]['id'];
						}
						
						if(array_key_exists("l", $_GET)) {
							if($_GET['l'] == "m")
								return "main_page.php";
							
							if($_GET['l'] == "s") {
								if(array_key_exists("q", $_GET)) {
									if(array_key_exists("d", $_GET))
										return "store.php?q=".$_GET['q']."&d=t";
									
									return "store.php?q=".$_GET['q'];
								}
								
								if(array_key_exists("d", $_GET))
									return "store.php?d=t";
									
								return "store.php";
							}
						}
						
						return "main_page.php";
					}
				}
			}
		}
		
		return $login_email_border_color.$login_password_border_color.$login_warning.$login_form_visibility.$sign_up_email_border_color.$sign_up_password_border_color
				.$sign_up_confirm_password_border_color.$sign_up_warning.$sign_up_form_visibility.$_POST['email'];
	}
	
	echo parse_request_data_status();
	
	unset($_POST);
	$_POST = array();
	
?>