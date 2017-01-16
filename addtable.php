<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>加入成功</title>
</head>

<?php
	$name=$_GET['name'];
	$start_year=$_GET['start_year'];
	$start_month=$_GET['start_month'];
	$start_day=$_GET['start_day'];
	$finish_year=$_GET['finish_year'];
	$finish_month=$_GET['finish_month'];
	$finish_day=$_GET['finish_day'];
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'admin');
    define('DB_NAME', 'database');

    
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = "CREATE TABLE `$name`(date_year INTEGER,date_month INTEGER,date_day INTEGER, `status` TEXT, photo_link TEXT,who TEXT,complish INTEGER)";
	mysqli_query($dbc,"SET NAMES 'UTF8'");
    mysqli_query($dbc, $query);
	$insert = "INSERT INTO list (name, start_year, start_month,start_day,finish_year, finish_month,finish_day, complish) VALUES ('$name' , $start_year,$start_month,$start_day
	,$finish_year,$finish_month, $finish_day,0)";
    mysqli_query($dbc, $insert);
	$query = "INSERT INTO `access_we` (name, start_year, start_month,start_day,finish_year, finish_month,finish_day, complish) VALUES ('$name' , $start_year,$start_month,$start_day
	,$finish_year,$finish_month, $finish_day,0)";
    mysqli_query($dbc, $query);
    echo "完成";
	if(!$dbc)
	{
		echo "wrong connect";
	}
		
?>
<script>
window.location.href = 'now.php'
</script>


<body>
</body>
</html>