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
    $query = "SELECT * FROM finish";
	mysqli_query($data,"SET NAMES 'UTF8'");
    $list=mysqli_query($data, $query);
	
?>
</head>

<body>
<h1>已結案工程</h1>

<table align="center"
          width=90% 
          border=2
          bgcolor=#FFFFFF 
          cellspadding=10>
<tr>
<td align="center" cellspadding=30>工程名稱</td>
<td align="center">工程起始時間</td>
<td align="center">工程截止時間</td>
<td align="center">工程當前進度</td>
<td align="center">操作</td>
</tr>

<?php
	for($i=1;$i<=mysqli_num_rows($list);$i++)
	{
		$show=mysqli_fetch_row($list);

?>
<tr border=2>
<td align="center"><?php echo $show[0]?> </td>
<td align="center"><?php echo "民國".$show[1]."年".$show[2]."月".$show[3]."日"?> </td>
<td align="center"><?php echo "民國".$show[4]."年".$show[5]."月".$show[6]."日"?> </td>
<td align="center"><?php echo $show[7]?> </td>
<td align="center" cellspadding=50><form action="comment.php" method="post">
<input type="hidden" value="<?php echo $show[0]?>" name='choose' >
<input type="hidden" value="finish" name='where' >
<input type="submit" value="檢視" />
</form>
<form action="deletework.php" method="post">
<input type="hidden" value="<?php echo $show[0]?>" name='choose' >
<input type="hidden" value="finish" name='where' >
<input type="submit" value="刪除" />
</form>

</td>
</tr>
<?php
	}
?>
</table>
</body>
</html>