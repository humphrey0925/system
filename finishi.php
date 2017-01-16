<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
<h1>工程結案</h1>
<?php
	$choose=$_POST['choose'];
	echo "你即將結案的工程名是：";
	echo $choose;
?>
<p>您確定是否將本工程結案（此操作不可復原！！！）<p>
<table>
<tr>
<td>
<form action="finish.php" method="post">
<input type="hidden" value="<?php echo $choose?>" name="table" />
<input type="submit" value="確認"  >
</form>
</td>
<td>
<form action="now.php" method="post">
<input type="submit" value="否認"  />

</form>
</td>
</tr>
<body>
</body>
</html>