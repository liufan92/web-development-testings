<?php
	include("../includes/db.php");
    $data = json_decode(file_get_contents("php://input"));
    $password = md5($data->password);
    $username = $data->username;

    $query = "SELECT username FROM users WHERE username='$username' AND password='$password'";

    $userInfo = $mysqli->query($query)or die($mysqli->error.__LINE__);

	$token; 
	if ($userInfo->num_rows == 1){
		//This means that the user is logged in and let's givem a token :D :D :D
		$token = $username . '|' . uniqid() . uniqid() . uniqid();
		
		$query = "UPDATE users SET token='$token' WHERE username='$username' AND password='$password'";
		$result = $mysqli->query($query)or die($mysqli->error.__LINE__);

	    echo json_encode($token);
	} else {
		echo json_encode("no match");
	}

?>