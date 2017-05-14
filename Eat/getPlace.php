<?php 	
	include("connect.php");	
	$link=Connection();	
	$sql = "select PlaceID,PlaceName from Place";	
	$result = mysql_query($sql);	
	$PlaceList = Array();	
	while($row = mysql_fetch_array($result))	
	{
		$Place = Array();		
		$Place['PlaceID'] = $row["PlaceID"];		
		$Place['PlaceName'] = $row["PlaceName"];		
		array_push($PlaceList,$Place);	
	}	
	//print_r($PlaceList);	
	echo json_encode($PlaceList);
?>