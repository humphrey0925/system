<?php	
	include("connect.php"); 			
	$link=Connection();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php	
	$response = array();	
	if(isset($_POST["PlaceID"]) && isset($_POST["MenuTitle"]) && isset($_POST["Price"]) && isset($_POST["Type"]) && isset($_POST["Session"]))	
	{		
		$PlaceID = $_POST["PlaceID"];		
		$MenuTitle = $_POST["MenuTitle"];		
		$Price = $_POST["Price"];		
		$Type = $_POST["Type"];		
		$Session = $_POST["Session"];		
		//echo $PlaceID." ".$MenuTitle." ".$Price." ".$Type;		
		$sql2 = "select MenuID from Menu where MenuTitle='$MenuTitle'";		
		$result2 = mysql_query($sql2);		
		if(mysql_num_rows($result4)==0)		
		{			
			$sql1 = "insert into Menu (MenuTitle,Type) values ('$MenuTitle',$Type)";			
			mysql_query($sql1);		
		}		
		//$sql2 = "select MenuID from Menu where MenuTitle='$MenuTitle' and Type = $Type";		
		$result2 = mysql_query($sql2);		
		$row2 = mysql_fetch_array($result2);		
		$MenuID = $row2[MenuID];		
		$sql3 = "insert into Serve values($PlaceID,$MenuID,$Price,$Session,1)";		
		mysql_query($sql3);	
	}	
	else	
	{		
		$response["status"] = 2;		
		$response["message"] = "Required field(s) is missing.";					
		echo json_encode($response);	
	}
?>