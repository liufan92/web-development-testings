<?php
include_once("../includes/check_login_status.php");
// Initialize any variables that the page might echo
$u = "";
$joindate = "";
$lastsession = "";
// Make sure the _GET username is set, and sanitize it
if(isset($_GET["u"])){
	$u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
} else {
    header("location: http://www.yoursite.com");
    exit();	
}
// Select the member from the users table
$sql = "SELECT * FROM users WHERE username='$u' LIMIT 1";
$user_query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($user_query);
if($numrows < 1){
	echo "Error: User not found";
    exit();	
}
// Check to see if the viewer is the account owner
$isOwner = "no";
if($u == $log_username && $user_ok == true){
	$isOwner = "yes";
}
// Fetch the user row from the query above
while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
	$profile_id = $row["id"];
	$signup = $row["signup"];
	$lastlogin = $row["lastlogin"];
	$joindate = strftime("%b %d, %Y", strtotime($signup));
	$lastsession = strftime("%b %d, %Y", strtotime($lastlogin));
}

if($isOwner == 'no'){
	header("location: login.php");
    exit();	
}

?>
<!DOCTYPE html>
<html ng-app="myapp">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MySite</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/bakery.css">
    <link rel="stylesheet" href="assets/css/todo.css">
    <link rel="stylesheet" href="assets/css/Footer-Clean.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
    <link rel="stylesheet" href="assets/css/Lightbox-Gallery.css">
    <link rel="stylesheet" href="assets/css/Navigation-Clean1.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
    <div ng-include='"assets/templates/nav.html"'></div>
	<div class="container-fluid" id="mySite" ng-controller="todoCtrl">
	    <div class="toDoBanner"></div>
	    <div>
	        <h1 class="text-center toDoHeading">Hi <?php echo $u; ?>! Forgot Something?</h1></div>
	    <div class="row">
	        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12" ng-repeat="postit in postits">
	            <div class="toDoItem" id="{{postit.id}}">
	                <h5>{{postit.title}}<button class="btn btn-default btn-xs doDoItemButton" type="button"> <i class="glyphicon glyphicon-remove" ng-click=deleteNote(postit)></i></button><button class="btn btn-default btn-xs doDoItemButton" type="button" ng-click=showList(postit)> <i class="glyphicon glyphicon-tag"></i></button></h5>
	                <hr>
	                <p>{{postit.description}}</p>
	            </div>
	        </div>
	        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
	            <a ng-click=newNote() class="addItem"> <i class="glyphicon glyphicon-plus"></i></a>
	        </div>
	    </div>
	    <a href='logout.php'>Click here to log out</a>
	</div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.9/angular.js"></script>
    <script src="https://rawgit.com/dwmkerr/angular-modal-service/master/dst/angular-modal-service.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular-animate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.3.2/angular-ui-router.js"></script>
    <script src="scripts/services/app.js"></script>
    <script src="assets/js/nav.js"></script>
    <script src="assets/js/todo.js"></script>
    <script src="assets/js/signup.js"></script>
    <script src="assets/js/login.js"></script>
    <script src="assets/js/ajax.js"></script>
</body>

</html>