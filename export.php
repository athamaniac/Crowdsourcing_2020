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
		$q = "SELECT user, heading, activities.type, activities.confidence, activities.timestamp as a_timestamp, verticalAccuracy, velocity, accuracy, latitude, longitude, altitude, data.timestamp as l_timestamp FROM data INNER JOIN activities ON activities.id = data.activity";
	}
	else if($activities_terms != "" && $time_terms == ""){
		$q = "SELECT heading, activities.type, activities.confidence, activities.timestamp as a_timestamp, verticalAccuracy, velocity, accuracy, latitude, longitude, altitude, data.timestamp as l_timestamp FROM data INNER JOIN activities ON activities.id = data.activity  WHERE ".$activities_terms."";
	}
	else if($activities_terms == "" && $time_terms != ""){
		$q = "SELECT heading, activities.type, activities.confidence, activities.timestamp as a_timestamp, verticalAccuracy, velocity, accuracy, latitude, longitude, altitude, data.timestamp as l_timestamp FROM data INNER JOIN activities ON activities.id = data.activity WHERE ".$time_terms."";
	}
	else{
		$q = "SELECT heading, activities.type, activities.confidence, activities.timestamp as a_timestamp, verticalAccuracy, velocity, accuracy, latitude, longitude, altitude, data.timestamp as l_timestamp FROM data INNER JOIN activities ON activities.id = data.activity WHERE ".$time_terms." AND (".$activities_terms.") ";
	}
	$result = $mysql_link->query($q);
	$export_data = array();
	if($data->type == 0){
		$file = fopen("myData.csv", "w");
		while($row = $result->fetch_array()){
			fputcsv($file, array($row["heading"], $row["type"], $row["confidence"], strtotime($row["a_timestamp"]) * 1000, $row["verticalAccuracy"], $row["velocity"], $row["accuracy"], $row["longitude"] * 10 ** 7, $row["latitude"] * 10 ** 7, $row["altitude"], strtotime($row["l_timestamp"]) * 1000,  $row["user"]));
		}
		fclose($file);
	}
	else if($data->type == 1){
		$file = fopen("myData.json", "w");
		$json = array();
		while($row = $result->fetch_array()){
			$json[] = array("heading" => $row["heading"],
							"activity.type" => $row["type"], 
							"activity.confidence" => $row["confidence"],
							"activity.timestampMs" => strtotime($row["a_timestamp"]) * 1000, 
							"verticalAccuracy" =>$row["verticalAccuracy"], 
							"velocity" => $row["velocity"], 
							"accuracy" => $row["accuracy"], 
							"longitudeE7" => $row["longitude"] * 10 ** 7, 
							"latitudeE7" => $row["latitude"] * 10 ** 7, 
							"altitude" => $row["altitude"],
							"timestampMs" => strtotime($row["l_timestamp"]) * 1000, 
							"userid" => $row["user"]);
		}
		fwrite($file, json_encode($json));
		fclose($file);
	}
?>