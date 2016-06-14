angular.module('realtimeApp').controller('SubmitOrderController',
    function ($scope, $http, $state) {
        $http.get("/order").then(function(response){
            $scope.orders = response.data;
        })

        $scope.approve = function(orderId) {

        }

        $scope.reject = function(orderId) {

        }
    });