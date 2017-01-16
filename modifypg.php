<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
<?php

	$update_year=$_POST['update_year'];
	$update_month=$_POST['update_month'];
	$update_day=$_POST['update_day'];
	$complish=$_POST['complish'];
	$comment=$_POST['comment'];
	$table=$_POST['table'];
	$where=$_POST['where'];
	$last=$_POST['last'];
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'admin');
    define('DB_NAME', 'database');

    
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($where=="comment"){
	$insert = "UPDATE `$table` SET date_year=$update_year, date_month=$update_month, date_day=$update_day,`status`='$comment', complish=$complish WHERE `status`='$last'";
	mysqli_query($dbc,"SET NAMES 'UTF8'");
    mysqli_query($dbc, $insert);
	}
	?>
    <form action="comment.php" method="post">完成<br />
<input type="hidden" value="<?php echo $table?>" name="choose" />
<input type="hidden" value="normal" name='where' >
<input type="submit" value="返回之前畫面"/>
<body>
</body>
</html>