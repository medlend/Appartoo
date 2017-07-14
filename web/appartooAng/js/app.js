angular.module('appartoo', ['appartoo.controllers', 'appartoo.services', 'ui.router', 'ngCookies'])
    .run(function($rootScope, $state, $stateParams, $cookieStore) {

        $rootScope.user = $cookieStore.get('mySession');
        $rootScope.logout = function() {
            $rootScope.user = null;
            $cookieStore.remove('mySession');
            $state.go('login');
        };
        $rootScope.$on('$stateChangeSuccess',
            function() {
                if (!$rootScope.user) {
                    $state.go('login');
                }
            });
    })
    .config(function($stateProvider, $urlRouterProvider) {
        $stateProvider
            .state('home', {
                url: '/',
                templateUrl: 'templates/home.html',
                controller: 'HomeCtrl'
            })
            .state('login', {
                url: '/login',
                templateUrl: 'templates/login.html',
                controller: 'LoginCtrl'
            })
        // if none of the above states are matched, use this as the fallback
        $urlRouterProvider.otherwise('/');
    });
