app.factory('Posts', ['$http', function($http){

  return{
    getPosts:function(){
      var response = $http({
        url: ajaxurl,
        method:'POST',
        params:{ action:'test_ajax'}
      }).then(function(response){
        return response.data;//[{'hello':'world'}];
      });
      return response;
    },
    processBooking:function(formdata){
      var data = formdata;
      var response = $http({
        url: ajaxurl,
        method:'POST',
        data:data,
        params:{ action:'process_booking'}
      }).then(function(response){
        return response.data;
      });
      return response;
    }
  }

}]);

