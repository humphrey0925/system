<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>隆易水電工程進度回報系統</title>
<style type="text/css">
.當前記事 {
	font-family: "標楷體";
}
</style>
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
</head>
<body>
<h1>公司總表</h1>
<table align="center"
          width=90% 
          border=3
          bgcolor=#FFFFFF 
          cellspadding=10>
          
<tr align="center">
<td class="當前記事">
當前記事

</td>
</tr> 
<tr>
<td>
<table align="center"
			width=100% 
          border=1
          bgcolor=#FFFFFF 
          cellspadding=10>
<tr>
<td align="center" width=10%>ID</td>
<td align="center">記事</td>
<td align="center" width=10%>操作</td>
<form action="">
</form>
</tr>
</table>
</td>
</tr>

         
          
</table>

</body>
</html>