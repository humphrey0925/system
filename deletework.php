<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
<h1>刪除工程</h1>
<br />
<br />
<h11>
<?php
	$choose=$_POST['choose'];
	$where=$_POST['where'];
	echo "你即將刪除的工程名是：";
	echo $choose;
?>
</h11>
<p>您確定是否刪除本工程（此操作不可復原！！！）<p>
<table>
<tr>
<td>
<form action="delete.php" method="post">
<input type="hidden" value="<?php echo $choose?>" name="table" />
<input type="hidden" value="<?php echo $where?>" name='where' >
<input type="submit" value="確認"  >
</form>
</td>
<td>

<form action="<?php if($where=="normal"){echo 'now.php';}else{echo 'allfinish.php';}?>" method="post">
<input type="submit" value="否認"  />
</form>
</td>
</tr>
<body>
</body>
</html>