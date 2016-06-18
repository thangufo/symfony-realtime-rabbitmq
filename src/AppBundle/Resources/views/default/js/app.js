'use strict';

angular.module('realtimeApp', ["ui.router", "ui.bootstrap"], function($httpProvider) {
})
    .config(['$stateProvider','$urlRouterProvider','$httpProvider', function($stateProvider, $urlRouterProvider,$httpProvider,$interpolateProvider) {
        $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
        $interpolateProvider.startSymbol('[[').endSymbol(']]');

        //routing start from here
        $urlRouterProvider.otherwise('/');

        $stateProvider
            .state('submitOrder', {
                url: '/order/submit',
                templateUrl: 'submitOrder.html',
                controller: 'SubmitOrderController'
            })
            .state('approveOrder', {
                url: '/order/approve',
                templateUrl: 'approveOrder.html',
                controller: 'ApproveOrderController'
            })
            .state('home', {
                url: '/',
                templateUrl: 'home.html',
            })
        }
    ]);
