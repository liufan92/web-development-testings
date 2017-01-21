<?php
	// CONNECT TO THE DATABASE
	include_once("../includes/db.php");
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES
	$data = json_decode(file_get_contents("php://input"));
    $username = $data->username;
    $email = $data->email;
    $password = md5($data->password);

    $query = "INSERT INTO users (username,email,password) VALUES ('$username','$email','$password')"; 

    $result = $mysqli->query($query) or die($mysqli->error.__LINE__);

	$result = $mysqli->affected_rows;

	echo $json_response = json_encode($username);

    /*$q = "INSERT INTO users (username, email password) VALUES (:username, :email, :password)";
    $query = $db_conx->prepare($q);
    $execute = $query->execute(array(
        ":username" => $username,
        ":email" => $email,
        ":password" => md5($password)
    ));*/

    //echo json_encode($username);

?>