<?php 
require_once '../includes/db.php'; // The mysql database connection script
if(isset($_GET['listID'])){
	$status = $mysqli->real_escape_string($_GET['status']);
	$listID = $mysqli->real_escape_string($_GET['listID']);

	$query="UPDATE postitList set status='$status' where id='$listID'";
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

	$result = $mysqli->affected_rows;

	$json_response = json_encode($result);
}
?>