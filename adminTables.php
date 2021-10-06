<?php
	session_start();
	if(!isset($_SESSION["user_id"])){
		header("Location:index.php");
	}
	if($_SESSION["usertype"] != 1){
		header("Location:userMain.php");
	}
	include_once("connect.php");
	$result = $mysql_link->query("SELECT COUNT(*) FROM activities INNER JOIN data ON activities.id = data.activity ");//Activities distribution
	$row = $result->fetch_array();
	$distr1 = array();
	$distr2 = array();
	$distr3 = array();
	$distr4 = array();
	$distr5 = array();
	$distr6 = array();
	if($row["COUNT(*)"] > 0){
		$count = $row["COUNT(*)"];
		$result = $mysql_link->query("SELECT COUNT(*), type FROM activities INNER JOIN data ON activities.id = data.activity  GROUP BY type");
		while($row = $result->fetch_array()){
			$distr1[] = array("type" => $row["type"], "pos" => $row["COUNT(*)"]/$count * 100);
		}
		
		$result = $mysql_link->query("SELECT COUNT(*), email FROM activities INNER JOIN data ON activities.id = data.activity INNER JOIN users ON users.id = data.user GROUP BY user");
		while($row = $result->fetch_array()){
			$distr2[] = array("user" => $row["email"], "pos" => $row["COUNT(*)"]/$count * 100);
		}
		
		$result = $mysql_link->query("SELECT COUNT(*), MONTHNAME(activities.timestamp) FROM activities INNER JOIN data ON activities.id = data.activity GROUP BY MONTH(activities.timestamp)");
		while($row = $result->fetch_array()){
			$distr3[] = array("month" => $row["MONTHNAME(activities.timestamp)"], "pos" => $row["COUNT(*)"]/$count * 100);
		} 
		
		$result = $mysql_link->query("SELECT COUNT(*), DAYNAME(activities.timestamp) FROM activities INNER JOIN data ON activities.id = data.activity GROUP BY DAYOFWEEK(activities.timestamp)");
		while($row = $result->fetch_array()){
			$distr4[] = array("day_week" => $row["DAYNAME(activities.timestamp)"], "pos" => $row["COUNT(*)"]/$count * 100);
		} 
		
		$result = $mysql_link->query("SELECT COUNT(*), HOUR(activities.timestamp) FROM activities INNER JOIN data ON activities.id = data.activity GROUP BY HOUR(activities.timestamp)");
		while($row = $result->fetch_array()){
			$distr5[] = array("hour" => $row["HOUR(activities.timestamp)"], "pos" => $row["COUNT(*)"]/$count * 100);
		} 
		
		$result = $mysql_link->query("SELECT COUNT(*), YEAR(activities.timestamp) FROM activities INNER JOIN data ON activities.id = data.activity GROUP BY YEAR(activities.timestamp)");
		while($row = $result->fetch_array()){
			$distr6[] = array("year" => $row["YEAR(activities.timestamp)"], "pos" => $row["COUNT(*)"]/$count * 100);
		} 
	}
	
	echo json_encode(array("d1" => $distr1, "d2" => $distr2, "d3" => $distr3, "d4" => $distr4, "d5" => $distr5, "d6" => $distr6));
?>