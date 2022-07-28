<?php
	require "../environment/env_read.php";
	require "../database_scripts/database_functions.php";
	const ERROR_USER_EXISTS = 2;
	
	function check_if_user_exists($user_data, $credentials) {
		$sql_select = "SELECT * FROM ".$credentials["USERS_TABLE"]." WHERE email='"
			.$user_data['email']."';";
		$user_entries = get_all_entries_from_database_table($credentials, 
			$credentials["USERS_DATABASE"], $sql_select);

		return $user_entries && is_array($user_entries);
	}
	
	function create_new_user($user_data) {
		$env_variables = get_variables();
		
		if(!create_database_if_not_existing($env_variables, $env_variables["USERS_DATABASE"]))
			return DatabaseOperationStatus::ERROR;
		
		$table_structure = $env_variables['USERS_TABLE']." ( 
			id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			email VARCHAR(65535) NOT NULL,
			password VARCHAR(65535) NOT NULL,
			date TIMESTAMP
		)";
		
		if(!create_table_in_database_if_not_exists($env_variables, 
			$env_variables["USERS_DATABASE"], $table_structure))
			
			return DatabaseOperationStatus::ERROR;
		
		if(check_if_user_exists($user_data, $env_variables)) 
			return ERROR_USER_EXISTS;
		
		if(!add_new_entry_to_database_table($env_variables, 
			$env_variables["USERS_DATABASE"], $env_variables["USERS_TABLE"], $user_data))
			
			return DatabaseOperationStatus::ERROR;
		
		return DatabaseOperationStatus::SUCCESS;
	}
?>