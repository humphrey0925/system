<?php
	function Connection()
	{
		$server="localhost";		
		$user="root";		
		$pass="root";		
		$db="eat_today";	   			
		$connection = mysql_connect($server, $user, $pass);		
		if (!$connection) 
		{	    	
			die('MySQL ERROR: ' . mysql_error());
		}		
		mysql_set_charset("utf8");		
		mysql_select_db($db) or die( 'MySQL ERROR: '. mysql_error() );	
		return $connection;	
	}
?>