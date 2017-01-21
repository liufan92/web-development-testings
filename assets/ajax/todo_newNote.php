<?php 
require_once '../includes/db.php'; // The mysql database connection script
if(isset($_GET['noteTitle'])){
	$noteTitle = $mysqli->real_escape_string($_GET['noteTitle']);
	$noteDescription = $mysqli->real_escape_string($_GET['noteDescription']);
	$currentUser = $mysqli->real_escape_string($_GET['user']);

	$query="INSERT INTO postit(title,description,belongTo)  VALUES ('$noteTitle','$noteDescription','$currentUser')";
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

	$result = $mysqli->affected_rows;

	echo $json_response = json_encode($result);
	}
?>