<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
<?php
	define('DB_HOST', '127.0.0.1');
    define('DB_USER', 'root');
    define('DB_PASS', 'admin');
    define('DB_NAME', 'database');

    $table=$_POST['table'];
	$data = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = "INSERT INTO finish SELECT * FROM list WHERE name='$table'";
	mysqli_query($data,"SET NAMES 'UTF8'");
    $list=mysqli_query($data, $query);
	$query = "DELETE FROM list WHERE name='$table'";
	mysqli_query($data,"SET NAMES 'UTF8'");
    $list=mysqli_query($data, $query);
	echo "完成";
?>
<script>
window.location.href = 'now.php'
</script>
<body>
</body>
</html>