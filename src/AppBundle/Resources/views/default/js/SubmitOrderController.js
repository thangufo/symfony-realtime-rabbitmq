angular.module('realtimeApp').controller('SubmitOrderController',
    function ($scope, $http, $state, WebsocketService) {
        $scope.order = {};
		$scope.submitted = false;
        WebsocketService.subscribe("/topic/orderAction",function(message){
			var order = JSON.parse(message.body);
			if ($scope.order.id == order.id) {
				$scope.order.status = order.status;
				$scope.submitted = false;
			}
        });
        $scope.submitForm = function(form) {
            $http.post("/order",$scope.order).then(function(response){
				$scope.order.id = response.data.id;
				$scope.submitted = true;
            })
        }
    });