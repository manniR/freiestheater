app.controller('HomeCtrl', ['$scope','Posts','$http', function($scope, Posts, $http){
  console.log('HomeController initialised');
   /* Posts.getPosts().then(function (data){
      $scope.posts = data;
      console.log('$scope.posts: '+ $scope.posts);
      });*/
  //var event = {};
  $scope.event = event;
  console.log($scope.event.title);
  console.log($scope.event.availableTickets);
  
  $scope.submitLogin = function(form){
    console.log($scope.event.title);
    console.log('from.user.email:::: ' + form);
    $scope.submitted = true;
    if(form.$invalid){
      return;
    }
//   $http.post('', JSON.stringify($scope.user)).success(function(){})
   Posts.processBooking($scope.user).then(function(response){
      console.log('RESPONSE FROM SCRIPT: ' + response);
    });
  }
}]);
