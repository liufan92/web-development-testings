angular
	.module("myapp")
	.controller('loginCtrl', function($scope,$http,$location,$state){

	$scope.loginInfo = {
        username: undefined,
        password: undefined
    }  

	$scope.loginUser =  function(){

		var data = {
            username: $scope.loginInfo.username,
            password: $scope.loginInfo.password
        }

		$http.post("assets/ajax/login.php", data).success(function(response){
            //console.log(response); // return token or 'username/password no match'
            localStorage.setItem("token", JSON.stringify(response));
            $state.go("todo");
            //$state.go("application", result);
        }).error(function(error){
            console.error(error);
        });

	}

});