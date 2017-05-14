<?php	
	include("connect.php"); 			
	$link=Connection();?><?php	$response = array();	
	if(isset($_POST["Input"]))	
	{		
		$Input = $_POST["Input"];		
		$sql = "select * from Menu where MenuTitle like '%$Input%'";		
		$result=mysql_query($sql);		
		if($result!==FALSE)		
		{			
			$data = array();			
			while($row = mysql_fetch_array($result))			
			{				
				array_push($data, $row['MenuTitle']);			
			}			
			echo json_encode($data);		
		}	
	}	
	else	
	{		
		$response["status"] = 2;		
		$response["message"] = "Required field(s) is missing.";					
		echo json_encode($response,JSON_UNESCAPED_SLASHES);	
	}
?>