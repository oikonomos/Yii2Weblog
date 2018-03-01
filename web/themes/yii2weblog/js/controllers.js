/* 
 * controllers.js
 * @Author : Sangbom, Suhk
 * @Written Date : 2017-11-02
 */

var controllers = angular.module('controllers', []);
controllers.controller('MainController', ['$scope', '$location', '$window',
        function ($scope, $location, $window) {
                $scope.loggedIn = function() {
                        return Boolean($window.sessionStorage.access_token);
                };
                $scope.logout = function () {
                        delete $window.sessionStorage.access_token;
                        $location.path('/login').replace();
                };
        }
]);