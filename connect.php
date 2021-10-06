<?php
	$mysql_link = new mysqli('localhost:3308', 'root', '', 'web2020');

	if (mysqli_connect_error()) 
		die('Connection Error ');

	$mysql_link->query ('SET CHARACTER SET utf8');
	$mysql_link->query ('SET COLLATION_CONNECTION=utf8_general_ci');
?>
