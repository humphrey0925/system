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
    $table=$_POST['table'];
	if($where=='normal')
	{
		$how='list';	
	}
	else
	{
		$how='finish';	
	}
	$data = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $query = "DELETE FROM $how WHERE name='$table'";
	mysqli_query($data,"SET NAMES 'UTF8'");
    $list=mysqli_query($data, $query);
	$query = "DROP TABLE $table";
	mysqli_query($data,"SET NAMES 'UTF8'");
    $list=mysqli_query($data, $query);
	$dir='./'.$table;
	function deldir($dir) {
  //先删除目录下的文件：
  $dh=opendir($dir);
  while ($file=readdir($dh)) {
    if($file!="." && $file!="..") {
      $fullpath=$dir."/".$file;
      if(!is_dir($fullpath)) {
          unlink($fullpath);
      } else {
          deldir($fullpath);
      }
    }
  }
 
  closedir($dh);
  //删除当前文件夹：
  if(rmdir($dir)) {
    return true;
  } else {
    return false;
  }
}
	echo "完成";
?>
<?php if($where=="normal") { ?>
<script>
window.location.href = 'now.php'
</script>
<?php }else{ ?>
<script>
window.location.href = 'allfinish.php'
</script>
<?php }?>
<body>
</body>
</html>