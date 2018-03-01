/* 
 * app.js
 * @Author : Sangbom, Suhk
 * @Written Date : 2017-11-02
 */
var app = angular.module('app', [
        'ngRoute',          // $routeProvider
        'mgcrea.ngStrap',   // bs-navbar, data-match-route directives
        'controllers'       // Our module frontend/web/js/controllers.js
]);

app.config(['$routeProvider', '$httpProvider',
        function($routeProvider, $httpProvider) {
                $routeProvider.
                        when('/', {
                                templateUrl: '/index.php',
                        }).
                        when('/login', {
                                templateUrl: '/login.php',
                                controller: 'LoginController'
                        }).
                        otherwise({
                            templateUrl: '/404.php'
                        });
                $httpProvider.interceptors.push('authInterceptor');
        }
]);

app.factory('authInterceptor', function ($q, $window, $location) {
        return {
                request: function (config) {
                        if ($window.sessionStorage.access_token) {
                                //HttpBearerAuth
                                config.headers.Authorization = 'Bearer ' + $window.sessionStorage.access_token;
                        }
                        return config;
                },
                responseError: function (rejection) {
                        if (rejection.status === 401) {
                                $location.path('/login').replace();
                        }
                        return $q.reject(rejection);
                }
        };
});

