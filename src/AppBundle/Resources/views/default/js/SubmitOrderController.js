angular.module('realtimeApp').controller('SubmitOrderController',
    function ($scope, $http, $state) {
        $scope.order = {};
        $scope.submitForm = function(form) {
            $http.post("/order",$scope.order).then(function(response){

            })
        }

    });