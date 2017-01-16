<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <?php 
  		define('DB_HOST', 'localhost');
   		 define('DB_USER', 'root');
    		define('DB_PASS', 'admin');
    		define('DB_NAME', 'database');

    
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
		mysqli_query($dbc,"SET NAMES 'UTF8'");
 
		$insert = "SELECT * FROM `customer_list`";
    mysqli_query($dbc, $insert);
  
  	
  ?>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    var availableTags = [
     <?php for($i=1;$i<=mysqli_num_rows($list);$i++)
	{
		$show=mysqli_fetch_row($list);?>
		"<?php echo $show[0];?>"
		<?php		if($i==mysqli_num_rows($list)){
					echo ",";
					}?>"
		
		<?php }?>
    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
<html>
<h1>濾芯更換需求增加</h1>
<?php   
	$name=$_POST[''];
	$user_id=$_POST[''];


?>
<table align="center"
		border="0"
        width="80%">
        <tr>
        <td>
<form action="adda.php" method='get'>
需求填報時間：</td>
<td>民國
<input type="text" name="start_year" value=""size=3>年
<input type="text" name="start_month" value=""size=1>月
<input type="text" name="start_day" value=""size=1>日</td>
</tr>
<tr>
<td>
客戶名稱：</td><td><?php echo $name."(id=".$user_id.")"?>
<div class="ui-widget">
  <label for="tags"></label>
  <input id="tags" name="user"  />
</div>

</form> </td></tr>
<tr><td>
備註:</td><td>
<textarea name="finish_day" style="width:300px;height:100px;">
</textarea><br />

</td></tr>
<tr>
<td>
<input type="submit" value="發送" >
</form> </td>
</tr>
</table>
<html>

<body>
</body>
</html>