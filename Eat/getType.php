<?php 	
	include("connect.php");	
	$link=Connection();	
	$sql = "select * from MenuType order by MenuTypeID;";	
	$result = mysql_query($sql);	
	$PlaceList = Array();	
	while($row = mysql_fetch_array($result))	
	{		
		$Place = Array();		
		$Place['MenuTypeID'] = $row["MenuTypeID"];		
		$Place['TypeTitle'] = $row["TypeTitle"];		
		array_push($PlaceList,$Place);	
	}	
	//print_r($PlaceList);	
	echo json_encode($PlaceList);
?>