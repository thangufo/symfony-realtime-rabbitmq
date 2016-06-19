angular.module('realtimeApp').controller('ApproveOrderController',
    function ($scope, $http, $state, WebsocketService,$timeout) {
        $scope.orders = [];
        $http.get("/order").then(function(response){
            $scope.orders = response.data;
        })
        WebsocketService.subscribe("/topic/newOrder",function(message){
            var order = JSON.parse(message.body);
            $scope.orders.unshift(order);
            $scope.$apply();
            $timeout(function(){
                order.new = false;
            },5000)
        });

        $scope.approve = function(order) {
            $http.post("/order/"+order.id+"/approve").then(function(response){
                order.status = 1;
            })
        }

        $scope.reject = function(order) {
            $http.post("/order/"+order.id+"/reject").then(function(response){
                order.status = -1;
            })
        }
    });