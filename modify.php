<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
<h1>修改</h1>
<?php
	$which=$_POST['status'];
	$where=$_POST['where'];
	$table=$_POST['table'];

	define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'admin');
    define('DB_NAME', 'database');
	$data = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if($where=="comment")
	{
		$query = "SELECT * FROM `$table` WHERE `status`='$which'";
	mysqli_query($data,"SET NAMES 'UTF8'");
    $list=mysqli_query($data, $query);
	$show=mysqli_fetch_row($list);
?>

<form action="modifypg.php" method="post">
您正在修改的工程名稱為<?php echo $where?>
<p>姓名:<?php echo $show[5]?>(上傳人員不得修改）</p>
日期：民國
<input type="TEXT" name="update_year" value="<?php echo $show[0]?>" size="3">年
<input type="TEXT" name="update_month" value="<?php echo $show[1]?>" size="1">月
<input type="TEXT" name="update_day" value="<?php echo $show[2]?>" size="1">日<br>
資料上傳：<?php echo $show[4]?>（不得修改）<br>
本日進度：<input type="TEXT" name="complish"size="1" value="<?php echo $show[6]?>">%<br>
進度概述：
<textarea name="comment">
<?php echo $show[3]?>
</textarea>
<br>
<input type="hidden" value="<?php echo $table ?>" name="table" />
<input type="hidden" value="<?php echo $where?>" name='where' >
<input type="hidden" value="<?php echo $which?>" name='last' >
<input type="submit" value="發送" >
</form>
<?php }  ?>
<body>
</body>
</html>