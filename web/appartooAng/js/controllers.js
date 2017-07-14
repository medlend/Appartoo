angular.module('appartoo.controllers', [])
    .controller('LoginCtrl', function($rootScope, $scope, $state, $cookieStore, loginService) {
        $scope.badCredentials = false;
        $scope.badToken = false;
        $scope.login = function(username, password) {
            loginService.login(username, password).then(function successCallback(response) {
                $scope.badCredentials = false;
                var api_token = response.data.access_token;
                loginService.getProfil(api_token).then(function successCallback(response) {
                    $scope.badToken = false;
                    var user = response.data;
                    $rootScope.user = user;
                    $rootScope.user.api_token = api_token;
                    $cookieStore.put('mySession', $rootScope.user);
                    $state.go('home');
                }, function errorCallback(response) {
                    $scope.badToken = true;
                })
            }, function errorCallback(response) {
                $scope.badCredentials = true;
            })
        };
    })
    .controller('HomeCtrl', function($rootScope, $scope, $state, FriendsService) {

        $scope.search = function(searchQuery) {
            FriendsService.searchFriends(searchQuery)
                .then(function successCallback(response) {
                    $scope.notFriends = response.data;
                }, function errorCallback(response) {
                    $scope.notFriends = [];
                })
        };
        $scope.add_Friend = function(friendId) {
            FriendsService.addFriend(friendId)
                .then(function successCallback(response) {
                    $rootScope.user.friends = response.data;
                    FriendsService.searchFriends($scope.searchQuery)
                        .then(function successCallback(response) {
                            $scope.notFriends = response.data;
                        }, function errorCallback(response) {
                            $scope.notFriends = [];
                        })
                }, function errorCallback(response) {
                    //
                })
        };
        $scope.remove_Friend = function(friendId) {
            FriendsService.removeFriend(friendId)
                .then(function successCallback(response) {
                    $rootScope.user.friends = response.data;
                    FriendsService.searchFriends($scope.searchQuery)
                        .then(function successCallback(response) {
                            $scope.notFriends = response.data;
                        }, function errorCallback(response) {
                            $scope.notFriends = [];
                        })
                }, function errorCallback(response) {
                    //
                })
        };

    });
