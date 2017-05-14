<?php	
	if(isset($_POST["PlaceID"]) && !empty($_POST["PlaceID"]) || isset($_GET["PlaceID"]) && !empty($_GET["PlaceID"]))	
	{		
		include("connect.php");		
		$link=Connection();		
		if(!empty($_POST["PlaceID"]))		
		{			
			$PlaceNumber = $_POST["PlaceID"];		
		}		
		else if(!empty($_GET["PlaceID"]))		
		{			
			$PlaceNumber = $_GET["PlaceID"];		
		}		
		$sql2 = "select M.MenuTitle,T.TypeTitle,S.Price,S.Session from Menu M,Serve S,MenuType T where M.MenuID = S.MenuID and S.PlaceID = $PlaceNumber and T.MenuTypeID = M.Type and S.Status=1";		
		$result2 = mysql_query($sql2);		
		if($result2!==FALSE)		
		{			
			if(mysql_num_rows($result2)>0)			
			{				
				echo "<table border=1 cellpadding=2><tr><td>Menu Title</td><td>Type</td><td>Price</td><td>Session Meal</td></tr>";				
				while($row2 = mysql_fetch_array($result2))				
				{				
					if($row2["Session"] == 1)					
					{					
						$session = "Yes";					
					}					
					else					
					{						
						$session="No";					
					}					
					//print_r($row2);					
					echo "<tr><td>$row2[0]</td><td>$row2[1]</td><td>$row2[2]</td><td>$session</td></tr>";					
					//echo "<tr><td>wdasdkgasdf</td></tr>";				
				}				
				echo "</table>";			
			}			
			else		
			{				
				echo "<tr><td colspan=4>No result return</td><tr>";			
			}		
		}	
	}
?>