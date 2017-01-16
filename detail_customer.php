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

    $choose=$_POST['choose'];
	$data = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = "SELECT * FROM `customer_list` WHERE `id` = $choose";
	mysqli_query($data,"SET NAMES 'UTF8'");
    $list=mysqli_query($data, $query);
	$show=mysqli_fetch_row($list);
?>
<h2>客戶資料<h2>

<table align="center"
		width=80% 
          border=0
          bgcolor=#FFFFFF 
          cellspadding=10
          style="font-size:18px;font-family:'標楷體'">
          
<tr>
<td width=15%>ID:</td>
<td><?php echo $show[3]?></td>


<td align="right"><form action="now_customer.php" method="post">
<input type="submit"  value="返回" />
</form></td>
</tr>
<tr>
<td width=15%>客戶名稱：</td>
<td align="left"><?php echo $show[0]?></td>


<td width=15%>聯絡電話:</td>
<td><?php echo $show[1]?></td>
</tr>
<tr>
<td width=15%>聯絡地址:</td>
<td><?php echo $show[2]?></td>
</tr>
</table>
<body>
</body>
</html>