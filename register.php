<?php
	include_once("connect.php");
	$requestPayload = file_get_contents("php://input");
	$data = json_decode($requestPayload);
	$email = $data->email;
	$pass = hash('gost', $data->pass);
	$first = $data->first;
	$last = $data->last;
	$secret_iv = 'RTlOMytOZStXdjdHbDZtamNDWFpGdz09';
	$output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $pass );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
	$user_id = base64_encode( openssl_encrypt( $email, $encrypt_method, $key, 0, $iv ) );
	if($mysql_link->query("INSERT INTO users(id, email, password, first_name, last_name) VALUES('".$user_id."', '".$email."', '".$pass."', '".$first."', '".$last."')")){
		session_start();
		$_SESSION["user_id"] = $row["id"];
		$_SESSION["username"] =  $row["username"];
		$_SESSION["email"] = $row["email"];
		$_SESSION["usertype"] = $row["role"];
		echo 1;
	} 
	else{
		echo 2;
	}
?>