<?php 
	include('../includes/db.php');
	$data = json_decode(file_get_contents("php://input"));
	$token = $data->token;

	//$query = "SELECT * FROM users WHERE token='$token'";
	$query = "SELECT * FROM users WHERE token=$token ";
	$check = $mysqli->query($query)or die($mysqli->error.__LINE__);

	//echo $check->num_rows;
	if ($check->num_rows == 1){
		echo "authorized";
	} else {
		echo "unauthorized";
	}

?>