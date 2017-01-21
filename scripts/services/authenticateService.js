app.service('AuthenticationService', ["$http", "$state", function($http, $state){
	var self = this;
	self.checkToken = function(token){
		var data = {token: token};

		$http.post("assets/ajax/checktoken.php", data).success(function(response){
			if (response == "unauthorized"){
				$state.go("login");
			} else {
				return response;
			}
		}).error(function(error){
			$state.go("login");
		})
		
	}

}]);