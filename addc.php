<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
<?php
	$user=$_POST['user'];
	$phone=$_POST['phone'];
	$address=$_POST['address'];
	define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'admin');
    define('DB_NAME', 'database');

    
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
	mysqli_query($dbc,"SET NAMES 'UTF8'");
 
	$insert = "INSERT INTO `customer_list` (`name`, `phone`, `address`) VALUES ('$user' , '$phone','$address')";
    mysqli_query($dbc, $insert);

    echo "完成";
	if(!$dbc)
	{
		echo "sql wrong connect";
		}
	
?>
<script>
window.location.href = 'now_customer.php'
</script>
<body>
</body>
</html>