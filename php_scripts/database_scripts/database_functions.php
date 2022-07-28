<?php
	abstract class DatabaseOperationStatus {
		const ERROR = 0;
		const SUCCESS = 1;
	}
	
	function create_database_if_not_existing($connection_credentials, $database_name) {	
		try {
			$connection = new PDO("mysql:host=".$connection_credentials["HOST"], $connection_credentials["USERNAME"], 
				$connection_credentials["PASSWORD"], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				
			$sql_create_database = "CREATE DATABASE IF NOT EXISTS ".$database_name;			
			$connection->exec($sql_create_database);
			
			return DatabaseOperationStatus::SUCCESS;
		}
		catch(PDOException $error) {
			echo $error->getMessage()."database\n";
			return DatabaseOperationStatus::ERROR;
		}
	}
	
	function create_table_in_database_if_not_exists($connection_credentials, $database_name, $table_structure) {
		try {
			$connection = new PDO("mysql:host=".$connection_credentials["HOST"], $connection_credentials["USERNAME"], 
				$connection_credentials["PASSWORD"], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		
			$sql_create_table = "USE ".$database_name.";";
			$sql_create_table .= sprintf("CREATE TABLE IF NOT EXISTS %s;", $table_structure);
			$connection->exec($sql_create_table);
			
			return DatabaseOperationStatus::SUCCESS;
		}
		catch(PDOException $error) {
			echo $error->getMessage()."table\n";
			return DatabaseOperationStatus::ERROR;
		}		
	}
	
	function add_new_entry_to_database_table($connection_credentials, $database_name, $table_name, $key_value_pairs) {		
		try {
			$dsn = "mysql:host=".$connection_credentials["HOST"].";dbname=".$database_name;
			$connection = new PDO($dsn, $connection_credentials["USERNAME"], 
				$connection_credentials["PASSWORD"], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				
			$sql_add_entry = sprintf("INSERT INTO %s (%s) VALUES (%s)", $table_name, implode(",", array_keys($key_value_pairs)), 
				":".implode(", :", array_keys($key_value_pairs)));
				
			$statement = $connection->prepare($sql_add_entry);
			$statement->execute($key_value_pairs);
			
			return DatabaseOperationStatus::SUCCESS;
		}
		catch(PDOException $error) {
			echo $error->getMessage()."entry\n";
			return DatabaseOperationStatus::ERROR;
		}
	}
	
	function get_all_entries_from_database_table($connection_credentials, $database_name, $sql_query) {
		try {
			$dsn = "mysql:host=".$connection_credentials["HOST"].";dbname=".$database_name;
			$connection = new PDO($dsn, $connection_credentials["USERNAME"], 
				$connection_credentials["PASSWORD"], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		
			$statement = $connection->prepare($sql_query);
			$statement->execute();
			
			return $statement->fetchAll();
		}
		catch(PDOException $error) {
			echo $error->getMessage()."check_entry\n";
			return DatabaseOperationStatus::ERROR;
		}
	}
?>