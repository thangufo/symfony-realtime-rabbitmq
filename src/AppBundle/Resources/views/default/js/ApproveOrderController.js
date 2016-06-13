angular.module('realtimeApp').controller('SubmitOrderController',
    function ($scope, $http, $state) {
        $http.get("/order").then(function(response){
            $scope.orders = response.data;
        })
    });