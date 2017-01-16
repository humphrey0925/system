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

    $search=$_GET['search'];
	$phone=$_GET['phone'];
	$data = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = "SELECT * FROM `customer_list` WHERE `name` LIKE '%$search%' AND `phone` LIKE '%$phone%'";
	mysqli_query($data,"SET NAMES 'UTF8'");
    $list=mysqli_query($data, $query);
	
?>
<body>
<h1>客戶查詢</h1>

<table align="center"
          width=* 
          border=0
          bgcolor=#FFFFFF 
          cellspadding=10>
<tr>
<td align="center">客戶名稱：</td>
<td align="center"><form action="now_customer.php" method="get">
<input type="text" name="search" size="30">
</td>
<td align="center">聯絡電話：</td>
<td align="center"><input type="text" name="phone" size="10"></td>
<td align="center">
<input type="submit" value="搜尋"  />
</form>
</td>
</tr>

</table>
<table align="center"
          width=* 
          border=2
          bgcolor=#FFFFFF 
          cellspadding=10>
<tr>
<td align="center">ID</td>
<td align="center" cellspadding=30>客戶名稱</td>
<td align="center">聯絡電話</td>
<td align="center">聯絡地址</td>
<td align="center">操作</td>

</tr>

<?php
	for($i=1;$i<=mysqli_num_rows($list);$i++)
	{
		$show=mysqli_fetch_row($list);

?>
<tr border=2>
<td align="center" width="10%"><?php echo $show[3]?> </td>
<td align="center" width="*"><?php echo $show[0]?> </td>
<td align="center" width="20%"><?php echo $show[1]?> </td>
<td align="center" width="40%"><?php echo $show[2]?> </td>
<td align="center" width="10%"><form action="detail_customer.php" method="post">
<input type="hidden" value="<?php echo $show[3]?>" name='choose' >
<input type="submit"  value="檢視" />
</form></td>
</tr>
<?php
	}
?>
</table>

</body>
</html>