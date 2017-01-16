<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
<?php 
  		define('DB_HOST', 'localhost');
   		 define('DB_USER', 'root');
    		define('DB_PASS', 'admin');
    		define('DB_NAME', 'database');
		$start_year=$_POST['start_year'];
		$start_month=$_POST['start_month'];
		$start_day=$_POST['start_day'];
		$user=$_POST['user'];
		$remark=$_POST['remark'];
    
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
		mysqli_query($dbc,"SET NAMES 'UTF8'");
 
		$insert = "select * FROM `customer_list`";
    mysqli_query($dbc, $insert);
  	echo "good  .".$user;
  	
  ?>
<body>
</body>
</html>