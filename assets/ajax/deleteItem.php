<?php 
require_once '../includes/db.php'; // The mysql database connection script
if(isset($_GET['itemID'])){
	$itemID = $mysqli->real_escape_string($_GET['itemID']);

	

	$get_query="SELECT IMAGEURL from things WHERE id = '$itemID'";
	$result = $mysqli->query($get_query) or die($mysqli->error.__LINE__);

	$arr = array();

	if($result->num_rows > 0){
		$row = $result->fetch_assoc();
		$path = $row['IMAGEURL'];

		//echo("<script>console.log('url: ".$url."');</script>");

		if(unlink($path)){
			$query="DELETE FROM things WHERE id = '$itemID'";
			$mysqli->query($query) or die($mysqli->error.__LINE__);
		}
	}
}
?>