var app = angular.module("myapp", ['ui.router','angularModalService','ngAnimate']);
//var app = angular.module("myapp", ['ngRoute','angularModalService','ngAnimate']);

app.config(['$urlRouterProvider','$stateProvider', function($urlRouterProvider,$stateProvider){
//app.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider){
	//$urlRouterProvider.otherwise('/');

	$stateProvider
		.state('home', {
			url: '/',
			templateUrl: 'assets/templates/home.html'
		})
		.state('bakery', {
			url:'/bakery',
			templateUrl: 'assets/templates/bakery.html',
			controller: "bakeryCtrl"
		})
		.state('todo', {
			url:'/todo',
			templateUrl: 'assets/templates/todo.html',
			controller: "todoCtrl"
		})
		.state('login', {
			url:'/login',
			templateUrl: 'assets/templates/login.html',
			controller: "loginCtrl"
		})
		.state('register', {
			url:'/register',
			templateUrl: 'assets/templates/register.html',
			controller: "registerCtrl"
		})
	/*$routeProvider
		.when('/home',{
			templateUrl:'assets/templates/home.html',
			//controller:'homeCtrl'
		})
		.when('/bakery',{
			templateUrl:'assets/templates/bakery.html',
			controller:'bakeryCtrl'

		})
		.when('/login',{
			templateUrl:'assets/templates/login.html',
			controller:'loginCtrl',


		})
		.when('/register',{
			templateUrl:'assets/templates/register.html',
			controller:'registerCtrl',


		})
		.when('/todo',{
			templateUrl:'assets/templates/todo.html',
			controller:'todoCtrl'

		})
		.otherwise({
			redirectTo: '/home'
		});*/

}]);

/*******************************************************************************
  					Controller for Bakery Page
********************************************************************************/

app.controller('bakeryCtrl', function($scope, $http){

	getItem("bakery"); // Load all available items from target table
	function getItem(table) {  
		$http.post("assets/ajax/getItem.php?table="+table).success(function(data){
			$scope.items = data;
			//$scope.$watch("items", console.log);
	    });
	};
	  
	$scope.addItem = function (item) {
	    $http.post("assets/ajax/addItem.php?item="+item).success(function(data){
	        getItem();
	        $scope.itemInput = "";
	    });
	};

});

/*******************************************************************************
  					Controller for TO-DO Page
********************************************************************************/

app.controller('todoCtrl', function($scope, $http, ModalService, AuthenticationService, $state){

	//Check if user logged in
	var token;

	if (localStorage['token']){
    	token = JSON.parse(localStorage['token']);
	} else {
		token = "Error";
	}

	AuthenticationService.checkToken(token);

	$tokenName = getUsername(token);
	
	getItem("postit"); // Load all postits from database

	function getItem(table) {  
		//$tokenName = getUsername(token);
		$http.post("assets/ajax/getItemByUsername.php?table="+table+"&u="+$tokenName).success(function(data){
			$scope.postits = data;
			//$scope.$watch("items", console.log);
	    });
	};

	function getUsername(token){
		$name = token.substr(1, token.indexOf('|')-1);
		console.log($name);
		return $name;
	}

	$scope.showList = function(postit){
		
		//console.log(postit.id);


		$http.post("assets/ajax/showModal.php?postitID="+postit.id).success(function(data){
				$scope.lists = data;
				$scope.$watch("lists", console.log);
		});

		ModalService.showModal({
			templateUrl: "assets/templates/todoCheckListModal.html",
			controller: "doDoCheckListModalCtrl",
			inputs: {
				title: postit.title,
				postitID: postit.id,
			}
		}).then(function(modal){
			modal.element.modal();
			/*modal.close.then(function(result) {
		        $scope.complexResult  = "Name: " + result.name + ", age: " + result.age;
		        console.log($scope.complexResult);
		      });*/
		});
	};

	$scope.newNote = function(){

		$tokenName= getUsername(token);

		ModalService.showModal({
			templateUrl: "assets/templates/todoNoteCreateModal.html",
			controller:"noteCreateCtrl",
			inputs: {
				username: $tokenName
			}
		}).then(function(modal){
			modal.element.modal();
			modal.close.then(function() {
		        getItem("postit");
		      });
		});

		
	};

	$scope.deleteNote = function(postit){

		if(confirm("Are you sure to delete this item?")){
	    	$http.post("assets/ajax/todo_deleteNote.php?postitID="+postit.id).success(function(data){
				getItem("postit");
	    	});
	    }
	};

	$scope.logout = function(){
		var data = {
			token: token
		}
		
		$http.post("assets/ajax/logout.php", data).success(function(response){
			//console.log(response);
			localStorage.clear();
			$state.go("login");
		}).error(function(error){
			console.error(error);
		})
	};


});

/*******************************************************************************
  					Controller for Note Creation Modal
********************************************************************************/

app.controller('noteCreateCtrl', function($scope,$http,close,username){

	$scope.noteTitle = "";
	$scope.noteDescription = "";

	$scope.saveNote = function(){

		$http.post("assets/ajax/todo_newNote.php?noteTitle="+$scope.noteTitle+"&noteDescription="+$scope.noteDescription+"&user="+username).success(function(data){
			close();
		});

	};

});


/*******************************************************************************
  					Controller for Check List Modal
********************************************************************************/
app.controller('doDoCheckListModalCtrl', function($scope,$http,title,postitID){
	
	//$scope.close = modals.resolve;
	$scope.title = title;
	$scope.currentPostitID = postitID;

	//console.log(postitID);
	fetchList();

	function fetchList() {
		$http.post("assets/ajax/showModal.php?postitID="+postitID).success(function(data){
			$scope.lists = data;
		});
	};

	$scope.addItem = function(itemName){
		$http.post("assets/ajax/todo_addList.php?postitID="+$scope.currentPostitID+"&itemName="+itemName).success(function(data){
	        fetchList();
	        $scope.addNewInput = "";
		});
	};

	$scope.removeItem = function(list){
		//console.log("This is itemID: ");
		//console.log(list.id);
		//$scope.$watch("lists", console.log);
		$http.post("assets/ajax/todo_removeList.php?listID="+list.id).success(function(data){
	        fetchList();
		});
		//console.log("after delete ajax~");
		//$scope.$watch("lists", console.log);
	};

	$scope.changeStatus = function(list){

		var status = null;
		console.log("list.status");
		console.log(list.status);
		if(list.status==2){status = 0;}else{status = 2;}
		console.log("status");
		console.log(status);
		$http.post("assets/ajax/todo_changeStatus.php?listID="+list.id+"&status="+status).success(function(data){
	        fetchList();
		});
	};

	$scope.clearItem = function(list){

		if(confirm("Delete all checked items?")){
	    	$http.post("assets/ajax/todo_clearItem.php?postitID="+$scope.currentPostitID).success(function(data){
	        	fetchList();
	    	});
	    }
	       
	};


});
