<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<?php
	define('DB_HOST', '127.0.0.1');
    define('DB_USER', 'root');
    define('DB_PASS', 'admin');
    define('DB_NAME', 'database');

    
	$data = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = "SELECT * FROM list";
	mysqli_query($data,"SET NAMES 'UTF8'");
    $list=mysqli_query($data, $query);
	
?>
</head>
<h1>請選擇您想查詢的工程：</h1>
<form action="comment.php" method='post'>
<select name="choose">
<?php
	for($i=1;$i<=mysqli_num_rows($list);$i++)
	{
		$show=mysqli_fetch_row($list);

?>
　<option value= <?php echo $show[0]?> > <?php echo $show[0]?> </option>
<?php }?>
　<input type="submit" value="發送" >
</select>
</form>
<body>
</body>
</html>