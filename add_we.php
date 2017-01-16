<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
<h3>增加水電工程</h3>
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
<form action="catch.php" method="post" enctype="multipart/form-data">
工程名稱：
<?php
	for($i=1;$i<=mysqli_num_rows($list);$i++)
	{
		$show=mysqli_fetch_row($list);

?>
<select name="choose">
　<option value= "<?php echo $show[0]?>" > <?php echo $show[0]?> </option></select>
<?php }?><br />申請時間：
<input type="TEXT" name="update_year" size="3">年
<input type="TEXT" name="update_month" size="1">月
<input type="TEXT" name="update_day"size="1">日<br>

<table align='left'>
<tr>
<td>
<input type="submit" value="發送" >
</form>
</td>
<td>
<form action="comment.php" method="post">
<input type="hidden" value="<?php echo $table?>" name="choose" />
<input type="hidden" value="normal" name="where" />
<input type="submit" value="取消" />
</form>
</td>
</tr>
</table>
<body>
</body>
</html>