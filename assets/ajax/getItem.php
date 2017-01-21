<?php 
include '../includes/db.php'; // The mysql database connection script
if(isset($_GET['table'])){
	$target_table = $mysqli->real_escape_string($_GET['table']);
	$query="SELECT * from $target_table" ;
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

	$arr = array();
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$arr[] = $row;	
		}
	}
}
# JSON-encode the response
echo $json_response = json_encode($arr);
?>