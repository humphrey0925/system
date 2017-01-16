<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
<?php    
	$name=$_POST['user'];
	$update_year=$_POST['update_year'];
	$update_month=$_POST['update_month'];
	$update_day=$_POST['update_day'];
	$complish=$_POST['complish'];
	$comment=$_POST['comment'];
	$table=$_POST['table'];
	$file=$_FILES["file"]["name"];
	$where=$_POST['where'];
	mkdir("./$table");
	move_uploaded_file($_FILES["file1"]["tmp_name"],"./$table/".$_FILES["file1"]["name"]);
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'admin');
    define('DB_NAME', 'database');

    
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$insert = "INSERT INTO `$table` (date_year, date_month, date_day,`status`,photo_link, who, complish) VALUES ($update_year,$update_month,$update_day
	,'$comment','$file','$name',$complish)";
	mysqli_query($dbc,"SET NAMES 'UTF8'");
    mysqli_query($dbc, $insert);
	$query = "UPDATE list
SET complish = $complish
WHERE name = '$table' ";
    mysqli_query($dbc, $query);
    echo "完成";
	if(!$dbc)
	{
		echo "wrong connect";
		}




?>
<form action="comment.php" method="post">
<input type="hidden" value="<?php echo $table?>" name="choose" />
<input type="hidden" value="<?php echo $where?>" name='where' >
<input type="submit" value="返回查詢畫面"/>

<body>
</body>
</html>