<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<body>
<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$DBName = "database";

	// Create connection
	//$conn = new mysqli($servername, $username, $password);

	$conn = mysqli_connect($servername, $username, $password,$DBName);

	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	else
	{
		echo "Connected successfully";
	}
?>
</body>
</html>