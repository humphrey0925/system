<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
<h3>請輸入你要提交的進度</h3>
<?php    

	$table=$_POST['table'];
	$where=$_POST['where'];
?>
<form action="catch.php" method="post" enctype="multipart/form-data">
姓名：
<input type="TEXT" name="user"><br />
日期：民國
<input type="TEXT" name="update_year" size="3">年
<input type="TEXT" name="update_month" size="1">月
<input type="TEXT" name="update_day"size="1">日<br>
檔案1：<input type="file" name="file1" id="file1" /><br>
<bt>檔案2：<input type="file" name="file2" id="file2" /><br />
檔案3：<input type="file" name="file3" id="file3" /><br />
檔案4：<input type="file" name="file4" id="file4" /><br />
檔案5：<input type="file" name="file5" id="file5" /><br />
檔案6：<input type="file" name="file6" id="file6" /><br />
本日進度：<input type="TEXT" name="complish"size="1">%<br>
進度概述：
<textarea name="comment">
請輸入本日工程狀況
</textarea>
<br>
<input type="hidden" value="<?php echo $table ?>" name="table" />
<input type="hidden" value="<?php echo $where?>" name='where' >
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