<?php
	function get_variables() {
		$variables = array();
		
		if(!is_readable(__DIR__.'/.env'))
			return $variables;
		
		$env_file_lines = file(__DIR__.'/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		foreach($env_file_lines as $line){
			$trimmed_line = trim($line);
			
			if (strpos($trimmed_line, '?') === 0)
                continue;
			
			list($key, $value) = explode("=", $trimmed_line, 2);
			$key = trim($key);
			$value = trim($value);
			
			$variables[$key] = $value;
		}
		
		return $variables;
		
	}
?>