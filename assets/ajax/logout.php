<?php 
	include('../includes/db.php');
	$data = json_decode(file_get_contents("php://input"));
	$token = $data->token;
	$query = "UPDATE users SET token='LOGGED OUT' WHERE token=$token";
	$mysqli->query($query)or die($mysqli->error.__LINE__);
?>