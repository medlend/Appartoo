angular.module('appartoo.services', [])
    .factory('loginService', function($http) {
        var loginFacotry = {};
        var grant_type = 'password';
        var client_id = '1_19vnw6j1rxc08ock0wg8c04408gggsc0ggk0o4g4o88o8ws40s';
        var client_secret = '5pm48ir6akkks4cgc4wgco0kwwc8ws0040cskwo4s8k000w4o4'
        loginFacotry.login = function(username, password) {
            var url = 'http://localhost/Appartoo/web/app.php/oauth/v2/token?grant_type=' + grant_type + '&client_id=' + client_id + '&client_secret=' + client_secret + '&username=' + username + '&password=' + password;
            return $http({
                url: url,
                method: 'GET'
            });
        };
        loginFacotry.getProfil = function(api_token) {
          var url = 'http://localhost/Appartoo/web/app.php/api/profile';
          return $http({
                url: url,
                method: 'GET',
                headers: {
                  'Authorization': 'Bearer ' + api_token
                }
            });
        };
        return loginFacotry;
    })
    .factory('FriendsService', function($http, $rootScope) {
        var FriendsFacotry = {};
        FriendsFacotry.searchFriends = function(searchKey) {
          var url = 'http://localhost/Appartoo/web/app_dev.php/api/find_friends';
          return $http({
                url: url,
                method: 'POST',
                headers: {
                  'Authorization': 'Bearer ' + $rootScope.user.api_token
                },
                data : {
                  key : searchKey,
                }
            });
        };
        FriendsFacotry.addFriend = function(id) {
          var url = 'http://localhost/Appartoo/web/app_dev.php/api/add_friend';
          return $http({
                url: url,
                method: 'POST',
                headers: {
                  'Authorization': 'Bearer ' + $rootScope.user.api_token
                },
                data : {
                  id : id,
                }
            });
        };
        FriendsFacotry.removeFriend = function(id) {
          var url = 'http://localhost/Appartoo/web/app_dev.php/api/remove_friend';
          return $http({
                url: url,
                method: 'POST',
                headers: {
                  'Authorization': 'Bearer ' + $rootScope.user.api_token
                },
                data : {
                  id : id,
                }
            });
        };
        return FriendsFacotry;
    })
    ;
