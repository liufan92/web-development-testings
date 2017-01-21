<?php 
require_once '../includes/db.php';
if(isset($_GET['postitID'])){
	$postitID = $mysqli->real_escape_string($_GET['postitID']);

	$query = "DELETE FROM postitList WHERE status = 2 AND postitID = '$postitID'";
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

	$result = $mysqli->affected_rows;

	echo $json_response = json_encode($result);
}
?>