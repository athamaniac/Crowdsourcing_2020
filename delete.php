<?php
	session_start();
	if(!isset($_SESSION["user_id"])){
		header("Location:index.php");
	}
	if($_SESSION["usertype"] != 1){
		header("Location:userMain.php");
	}
	include_once("connect.php");
	if($mysql_link->query("DELETE FROM data")){
		echo 1;
	}
	else{
		echo $mysql_link->error;
	}
	if($mysql_link->query("DELETE FROM activities")){
		echo 1;
	}
	else{
		echo $mysql_link->error;
	}
	
?>