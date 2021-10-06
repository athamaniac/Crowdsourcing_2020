<?php
	session_start();
	if(!isset($_SESSION["user_id"])){
		header("Location:index.php");
	}
	if($_SESSION["usertype"] != 1){
		header("Location:userMain.php");
	}
	include_once("connect.php");
	$requestPayload = file_get_contents("php://input");
	$data = json_decode($requestPayload);
	$time_terms = "";
	if(($data->month_from != -1 && $data->month_to != -1) && $time_terms == ""){
		$time_terms .= " MONTH(activities.timestamp) >= ".$data->month_from." AND MONTH(activities.timestamp) <= ".$data->month_to.""; 
	}
	if(($data->year_from != -1 && $data->year_to != -1) && $time_terms == ""){
		$time_terms .= " YEAR(activities.timestamp) >= ".$data->year_from." AND YEAR(activities.timestamp) <= ".$data->year_to.""; 
	}
	else if(($data->year_from != -1 && $data->year_to != -1) && $time_terms != ""){
		$time_terms .= " AND YEAR(activities.timestamp) >= ".$data->year_from." AND YEAR(activities.timestamp) <= ".$data->year_to.""; 
	}
	if(($data->hour_from != -1 && $data->hour_to != -1) && $time_terms == ""){
		$time_terms .= " HOUR(activities.timestamp) >= ".$data->hour_from." AND HOUR(activities.timestamp) <= ".$data->hour_to.""; 
	}
	else if(($data->hour_from != -1 && $data->hour_to != -1) && $time_terms != ""){
		$time_terms .= " AND HOUR(activities.timestamp) >= ".$data->hour_from." AND HOUR(activities.timestamp) <= ".$data->hour_to."";
	}
	if(($data->day_from != -1 && $data->day_to != -1) && $time_terms == ""){
		$time_terms .= " DAYOFWEEK(activities.timestamp) >= ".$data->day_from." AND DAYOFWEEK(activities.timestamp) <= ".$data->day_to.""; 
	}
	else if(($data->day_from != -1 && $data->day_to != -1) && $time_terms != ""){
		$time_terms .= " AND DAYOFWEEK(activities.timestamp) >= ".$data->day_from." AND DAYOFWEEK(activities.timestamp) <= ".$data->day_to.""; 
	}
	if($data->activities != null){
		for($i = 0; $i < count($data->activities); $i++){
			$data->activities[$i] = "type = '".$data->activities[$i]."'";
		}
	}
	$activities_terms = implode(" OR ",$data->activities);
	if($activities_terms == "" && $time_terms == ""){
		$q = "SELECT DISTINCT latitude, longitude, COUNT(*) FROM data GROUP BY longitude, latitude";
	}
	else if($activities_terms != "" && $time_terms == ""){
		$q = "SELECT DISTINCT latitude, longitude, COUNT(*) FROM data INNER JOIN activities ON activities.id = data.activity  WHERE ".$activities_terms." GROUP BY longitude, latitude";
	}
	else if($activities_terms == "" && $time_terms != ""){
		$q = "SELECT DISTINCT latitude, longitude, COUNT(*) FROM data INNER JOIN activities ON activities.id = data.activity WHERE ".$time_terms." GROUP BY longitude, latitude";
	}
	else{
		$q = "SELECT DISTINCT latitude, longitude, COUNT(*) FROM data INNER JOIN activities ON activities.id = data.activity WHERE ".$time_terms." AND (".$activities_terms.") GROUP BY longitude, latitude";
	}
	$result = $mysql_link->query($q);
	$locations = array();
	$max = 0;
	while($row = $result->fetch_array()){
		if($row["COUNT(*)"] > $max){
			$max = $row["COUNT(*)"];
		}
		$locations[] = array("longitude" => $row["longitude"], "latitude" => $row["latitude"], "c" => $row["COUNT(*)"]);
	}
	echo json_encode(array("max" => $max, "locations" => $locations));
?>