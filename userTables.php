<?php
	session_start();
	if(!isset($_SESSION["user_id"])){
		header("Location:index.php");
	}
	if($_SESSION["usertype"] != 0){
		header("Location:adminMain.php");
	}
	include_once("connect.php");
	$month = date('m'); 
	$result = $mysql_link->query("SELECT COUNT(*) FROM activities INNER JOIN data ON activities.id = data.activity WHERE month(activities.timestamp) = ".$month." AND user = '".$_SESSION['user_id']."'");
	$row = $result->fetch_array();
	if($row["COUNT(*)"] != 0){//Echo current month
		$result = $mysql_link->query("SELECT COUNT(*) FROM activities INNER JOIN data ON activities.id = data.activity WHERE month(activities.timestamp) = ".$month." AND (type = 'WALKING' OR type = 'ON_BICYCLE' OR type = 'ON_FOOT' OR type = 'RUNNING') AND user = '".$_SESSION['user_id']."'");
		$row2 = $result->fetch_array();
		$echo_current = $row2["COUNT(*)"]/$row["COUNT(*)"] * 100;
	}
	else{
		$echo_current = 0;
	}
	$echo_prev = array();//Echo for past year
	$result = $mysql_link->query("SELECT COUNT(*), MONTH(activities.timestamp), YEAR(activities.timestamp) FROM activities INNER JOIN data ON activities.id = data.activity WHERE activities.timestamp >=  DATE_SUB(NOW(),INTERVAL 1 YEAR) AND user = '".$_SESSION['user_id']."' GROUP BY MONTH(activities.timestamp)");
	while($row = $result->fetch_array()){
		if($row["COUNT(*)"] != 0){
			$result2 = $mysql_link->query("SELECT COUNT(*) FROM activities INNER JOIN data ON activities.id = data.activity WHERE MONTH(activities.timestamp) =  ".$row["MONTH(activities.timestamp)"]." AND YEAR(activities.timestamp) = ".$row["YEAR(activities.timestamp)"]." AND (type = 'WALKING' OR type = 'ON_BICYCLE' OR type = 'ON_FOOT' OR type = 'RUNNING') AND user = '".$_SESSION['user_id']."'");
			$row2 = $result2->fetch_array();
			$echo_prev[] = array('date' => $row["MONTH(activities.timestamp)"]." ".$row["YEAR(activities.timestamp)"], "p" => $row2["COUNT(*)"]/$row["COUNT(*)"] * 100);
		}
		else{
			$echo_prev[] = array('date' => $row["MONTH(activities.timestamp)"]." ".$row["YEAR(activities.timestamp)"], "p" => 0);
		}
		
	}
	$result = $mysql_link->query("SELECT MIN(timestamp), MAX(timestamp) FROM data WHERE user = '".$_SESSION['user_id']."'");
	$row = $result->fetch_array();
	$range = array("start" => date("d-m-Y", strtotime($row["MIN(timestamp)"])), "end" => date("d-m-Y",strtotime($row["MAX(timestamp)"])));
	$result = $mysql_link->query("SELECT upload FROM users WHERE id = '".$_SESSION['user_id']."'");
	$row = $result->fetch_array();
	echo json_encode(array("echo" => $echo_current, "echo_year" => $echo_prev, "range" => $range, "upload" => date("d-m-Y",strtotime($row["upload"]))));
	$mysql_link->close();
?>