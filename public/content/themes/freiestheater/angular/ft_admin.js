/**
 * Created by macbookpro on 12.05.14.
 */
var ft_admin = angular.module('ft_admin', ['ngResource']);

ft_admin.controller('EventCtrl', ['$scope','Eventservice', '$resource', function($scope, Eventservice, $resource){

    var Booking = $resource(ajaxurl,{action:'getBookings_ajax'},{'query':{method:'get'}});

  window.Booking = Booking;

//  $scope.bookings = Eventservice.getBookings();



}]);



ft_admin.factory('Eventservice',['$http', function($http){

  return{
    getBookings: function(date){
      var response = $http({
        url: ajaxurl,
        method: 'GET',
        data:date,
        params:{action:'getBookings_ajax'}
      }).then(function (response){
        return response;
      });
      //return response;
      return { "data" :"hello from Service"};
    }
  }

}]);