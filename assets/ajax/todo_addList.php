<?php 
require_once '../includes/db.php'; // The mysql database connection script
if(isset($_GET['postitID']) && isset($_GET['itemName'])){
	$item = $mysqli->real_escape_string($_GET['itemName']);
	$target_postit = $mysqli->real_escape_string($_GET['postitID']);
	$status = "0";

	$query="INSERT INTO postitList(postitID,name,status)  VALUES ('$target_postit', '$item', '$status')";
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

	$result = $mysqli->affected_rows;

	echo $json_response = json_encode($result);
	}
?>