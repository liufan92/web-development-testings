<?php 
require_once '../includes/db.php'; // The mysql database connection script
if(isset($_GET['postitID'])){
	$postitID = $mysqli->real_escape_string($_GET['postitID']);

	$query="DELETE FROM postit WHERE id = '$postitID'";
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

	$query="DELETE FROM postitList WHERE postitID = '$postitID'";
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

}
?>