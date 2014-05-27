var app = angular.module('app', []);

app.controller('BookingCtrl', ['$scope', 'Posts', '$http', function ($scope, Posts, $http) {
  console.log('BookingController initialised');
  /* Posts.getPosts().then(function (data){
   $scope.posts = data;
   console.log('$scope.posts: '+ $scope.posts);
   });*/
  //var event = {};
  //$scope.event = event;

  //console.log($scope.event.availableTickets);

  $scope.submitLogin = function (form) {
    //console.log($scope.event.title);
    console.log('from.user.email:::: ' + form);
    $scope.submitted = true;
    if (form.$invalid) {
      return;
    }
//   $http.post('', JSON.stringify($scope.user)).success(function(){})
    Posts.processBooking($scope.user).then(function (response) {
      console.log('RESPONSE FROM SCRIPT: ' + response);
    });

  }
  var eventinfos = {};


  $scope.submitBookingForm = function(id) {
    eventinfos = $scope.eventinfos;
    for (var key in eventinfos) {
      console.log(key + ': ' + eventinfos[key]);
    }

    console.log(eventinfos.date);


   /* console.log('$scope.event.id ::: ' + $scope.event.id);
    console.log('$scope.event.date ::: ' + $scope.event.id);
*/
    console.log( id +' form submited');

  }


}]);

app.factory('Posts', ['$http', function ($http) {

  return{
    getPosts: function () {
      var response = $http({
        url: ajaxurl,
        method: 'POST',
        params: { action: 'test_ajax'}
      }).then(function (response) {
        return response.data;//[{'hello':'world'}];
      });
      return response;
    },
    processBooking: function (formdata) {
      var data = formdata;
      var response = $http({
        url: ajaxurl,
        method: 'POST',
        data: data,
        params: { action: 'process_booking'}
      }).then(function (response) {
        return response.data;
      });
      return response;
    }
  }

}]);

