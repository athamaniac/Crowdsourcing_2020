<?php
	session_start();
	if(!isset($_SESSION["user_id"])){
		header("Location:index.php");
	}
	if($_SESSION["usertype"] != 0){
		header("Location:adminMain.php");
	}
	include_once("connect.php");
	$requestPayload = file_get_contents("php://input");
	$data = json_decode($requestPayload);
	$from_month = $data->from_month+1;
	$to_month = $data->to_month+1;
	$from_year = $data->from_year;
	$to_year = $data->to_year;
	$result = $mysql_link->query("SELECT COUNT(*) FROM activities INNER JOIN data ON activities.id = data.activity WHERE user = '".$_SESSION["user_id"]."' AND MONTH(activities.timestamp) >= ".$from_month." AND MONTH(activities.timestamp) <= ".$to_month." AND YEAR(activities.timestamp) >= ".$from_year." AND YEAR(activities.timestamp) <= ".$to_year."");//Percent per type
	$percent = array();
	while($row = $result->fetch_array()){
		if($row["COUNT(*)"] != 0){
			$result2 = $mysql_link->query("SELECT COUNT(*), type FROM activities INNER JOIN data ON activities.id = data.activity WHERE user = '".$_SESSION["user_id"]."' AND MONTH(activities.timestamp) >= ".$from_month." AND MONTH(activities.timestamp) <= ".$to_month." AND YEAR(activities.timestamp) >= ".$from_year." AND YEAR(activities.timestamp) <= ".$to_year." GROUP BY type");
			while($row2 = $result2->fetch_array()){
				$percent[] = array('activity_type' => $row2["type"], "p" => $row2["COUNT(*)"]/$row["COUNT(*)"] * 100);
			}
		}
		else{
			$result2 = $mysql_link->query("SELECT DISTINCT type FROM activities INNER JOIN data ON activities.id = data.activity WHERE user = '".$_SESSION["user_id"]."'");
			while($row2 = $result2->fetch_array()){
				$percent[] = array('activity_' => $row2["type"], "p" => 0);
			}
			
		}
	}
	//Activity type and day with most records per type
	$result = $mysql_link->query("CREATE OR REPLACE VIEW my_view AS
								  SELECT DAYNAME(activities.timestamp) AS nameday, type, COUNT(*) AS total
								  FROM activities
								  INNER JOIN data ON activities.id = data.activity
								  WHERE user ='".$_SESSION['user_id']."' AND MONTH(activities.timestamp) >= ".$data->from_month." AND MONTH(activities.timestamp) >= ".$from_month." AND MONTH(activities.timestamp) <= ".$to_month." AND YEAR(activities.timestamp) >= ".$from_year." AND YEAR(activities.timestamp) <= ".$to_year."
								  GROUP BY DAYOFWEEK(activities.timestamp), type
								  ORDER BY type, COUNT(*)");
	$result2 = $mysql_link->query("SELECT nameday, type, total  
									FROM `my_view` 
								   WHERE total IN (SELECT MAX(total) FROM my_view GROUP BY type)");
	$day_of_week = array();
	while($row = $result2->fetch_array()){
		$day_of_week[] = array("day" => $row["nameday"], "activity" => $row["type"], "total" => $row["total"]);
	} 
	//Activity type and hour with most records per type
	$result = $mysql_link->query("CREATE OR REPLACE VIEW my_view AS
								  SELECT HOUR(activities.timestamp) AS hour, type, COUNT(*) AS total
								  FROM activities
								  INNER JOIN data ON activities.id = data.activity
								  WHERE user ='".$_SESSION['user_id']."' AND MONTH(activities.timestamp) >= ".$from_month." AND MONTH(activities.timestamp) <= ".$to_month." AND YEAR(activities.timestamp) >= ".$from_year." AND YEAR(activities.timestamp) <= ".$to_year."
								  GROUP BY HOUR(activities.timestamp), type
								  ORDER BY type, COUNT(*)");
	$result2 = $mysql_link->query("SELECT hour, type, total  
									FROM `my_view` 
								   WHERE total IN (SELECT MAX(total) FROM my_view GROUP BY type)");
	$hour = array();
	while($row = $result2->fetch_array()){
		$hour[] = array("hour" => $row["hour"], "activity" => $row["type"], "total" => $row["total"]);
	} 
	$result = $mysql_link->query("SELECT DISTINCT longitude, latitude, COUNT(*) FROM data WHERE user = '".$_SESSION["user_id"]."' AND MONTH(timestamp) >= ".$from_month." AND MONTH(timestamp) <= ".$to_month." AND YEAR(timestamp) >= ".$from_year." AND YEAR(timestamp) <= ".$to_year." GROUP BY longitude, latitude");
	$max = 0;
	$locations = array();
	while($row = $result->fetch_array()){
		$locations[] = array("longitude" => $row["longitude"], "latitude" => $row["latitude"], "c" => $row["COUNT(*)"]);
		if($max < $row["COUNT(*)"]){
			$max = $row["COUNT(*)"];
		}
	}
	$map_data = array("max" => $max, "locations" => $locations); 
	echo json_encode(array("percent" => $percent, "day" => $day_of_week, "hour" => $hour, "locations" => $map_data));
	$mysql_link->close();
?>