angular
	.module("myapp")
	.controller('registerCtrl', function($scope,$http,$location,$rootScope,$state){

            //Variables
    $scope.signUpInfo = {
        username: undefined,
        email: undefined,
        password: undefined
    }

    $scope.signUserUp = function (){
        $scope.dataLoading = true;

        var data = {
            username: $scope.signUpInfo.username,
            email: $scope.signUpInfo.email,
            password: $scope.signUpInfo.password
        }

        $http.post("assets/ajax/signup.php", data).success(function(response){
            //console.log(response);
            localStorage.setItem("token", JSON.stringify(response));
            $state.go("login");
        }).error(function(error){
            //console.error(error);
            $scope.dataLoading = false;
        });

    }
});