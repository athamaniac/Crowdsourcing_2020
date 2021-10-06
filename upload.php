<?php
	session_start();
	ini_set('memory_limit', '-1');
	if(!isset($_SESSION["user_id"])){
		header("Location:index.php");
	}
	if($_SESSION["usertype"] != 0){
		header("Location:adminMain.php");
	}
	if (file_exists($_FILES["file"]["name"]))
	{
		unlink($_FILES["file"]["name"]);
		move_uploaded_file($_FILES["file"]["tmp_name"], $_FILES["file"]["name"]);
	}
	else
	{
		move_uploaded_file($_FILES["file"]["tmp_name"], $_FILES["file"]["name"]);
	}
	include_once("connect.php");
	$mysql_link->query("UPDATE users SET upload = '".date ("Y-m-d H:i:s")."'");
	$file = file_get_contents($_FILES["file"]["name"]);
	$json = json_decode($file);
	$loc = array();
	$act = array();
	$result = $mysql_link->query("SELECT id FROM activities ORDER BY id DESC LIMIT 1");
	$row = $result->fetch_array();
	if($row["id"] == null){
		$id = 0;
	}
	else{
		$id = $row["id"];
	}
	foreach($json as $element){
		foreach($element as $location){
			$heading = (isset($location->heading)) ? $location->heading : 0;
			$verticalAccuracy = (isset($location->verticalAccuracy)) ? $location->verticalAccuracy : 0;
			$velocity = (isset($location->velocity)) ? $location->velocity : 0;
			$altitude = (isset($location->altitude)) ? $location->altitude : 0;
			if(isset($location->activity)){
				foreach($location->activity as $location_activity){
					if(isset($location_activity->activity)){
						foreach($location_activity->activity as $activity){
							$id++;
							$act[] = "(".$id.", '".$activity->type."' , ".$activity->confidence." , '".date ("Y-m-d H:i:s", $location_activity->timestampMs / 1000)."')";
							$loc[] = "('".$_SESSION["user_id"]."', ".$heading.", ".$id.", ".$verticalAccuracy.",". $velocity.",".$location->accuracy.",".($location->longitudeE7 / 10 ** 7).",". ($location->latitudeE7 / 10 **7).",". $altitude.",'".date ("Y-m-d H:i:s", $location->timestampMs / 1000)."')";
						}
					}
				}
			}
			else{
				$loc[] = "('".$_SESSION["user_id"]."', ".$heading.", NULL, ".$verticalAccuracy.",". $velocity.",".$location->accuracy.",".($location->longitudeE7 / 10 ** 7).",". ($location->latitudeE7 / 10 **7).",". $altitude.",'".date ("Y-m-d H:i:s", $location->timestampMs / 1000)."')";
			}
		}
	}
	if($mysql_link->query("INSERT INTO activities(id, type, confidence,timestamp) VALUES ".implode(",", $act))){
		echo "Επιτυχής εισαγωγή δραστηριοτήτων<br>" ;
	}
	else{
		echo "Υπήρξε πρόβλημα με την εισαγωγή δραστηριοτήτων ".$mysql_link->error."<br>";
		
	}
	if($mysql_link->query("INSERT INTO data(user, heading, activity,verticalAccuracy, velocity, accuracy, longitude, latitude, altitude, timestamp) VALUES ".implode(",", $loc))){
		echo "Επιτυχής εισαγωγή τοποθεσιών <br>" ;
	}
	else{
		echo "Υπήρξε πρόβλημα με την εισαγωγή τοποθεσιών ".$mysql_link->error."<br>";
	}
	$mysql_link->close();
	
?>