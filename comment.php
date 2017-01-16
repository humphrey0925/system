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
	$where=$_POST['where'];
    $choose=$_POST['choose'];
	/*$conn_id = ftp_connect('localhost');
	ftp_login($conn_id, 'admin', 'longyiboss');*/
	$data = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = "SELECT * FROM `$choose` ORDER BY date_year DESC, date_month DESC, date_day DESC";
	mysqli_query($data,"SET NAMES 'UTF8'");
    $list=mysqli_query($data, $query);

	
	
?>
<body>
<?php
	echo "您選擇的工程名稱為".$choose.",以下是它的目前狀況：";
	if($where=="normal"){
?>

<table align="center"
          width=90% 
          border=0
          bgcolor=#FFFFFF 
          cellspadding=10>
<tr>
<td align="left"><form action="pinglun.php" method='post'>
<input type="hidden" value ="<?php echo $choose?>" name='table' />
<input type="hidden" value="<?php echo $where?>" name='where' />
<input type="submit" value="新增進度" />
</form></td><?php  }?>
<td align="right" ><?php  
if($where=="normal"){
?>
<form action="now.php" method='post'><?php }else{
?>
<form action="allfinish.php" method='post'>
<?php } ?>
<input type="submit" value="返回上一層" />
</form>
</td>

</tr>
</table>

<table align="center"
          width=90% 
          border=2
          bgcolor=#FFFFFF 
          cellspadding=10>
<tr>
<td align="center">上傳時間</td>
<td align="center" cellspadding=30>進度概述</td>

<td align="center">上傳圖片</td>
<td align="center">工程當前進度</td>
<td align="center">上傳人員</td>
<td align="center">操作</td>
</tr>

<?php
	for($i=1;$i<=mysqli_num_rows($list);$i++)
	{
		$show=mysqli_fetch_row($list);

?>
<tr border=2>
<td align="center"><?php echo "民國".$show[0]."年".$show[1]."月".$show[2]."日"?> </td>
<td align="center"><?php echo $show[3]?> </td>

<td align="center"><img src="./<?php echo $choose.'/'.$show[4]?>" width="300" height="*"></td>
<td align="center"><?php echo $show[6]?> %</td>
<td align="center"><?php echo $show[5]?> </td>
<td align="center"><?php if($where=="normal"){ ?><form action="modify.php" method="post">
<input type="hidden" value="<?php echo $show[3]?>" name='status' >
<input type="hidden" value="comment" name='where' >
<input type="hidden" value ="<?php echo $choose?>" name='table' />

<input type="submit" value="修改" />
</form>
<?php }?>
</td>
</tr>
<?php
	}
?>
</table>

</body>
</html>