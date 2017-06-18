var controllerList = {};
var ngControllerInit = function(controllerName, controller) {
    controllerList[controllerName] = controller;
};
var getTemplatePath = function(controllerName, controller) {
    controllerList[controllerName] = controller;
};

var copy = angular.copy;
var globalVar = {};
var app = angular.module('webapp', [
    'ngRoute',
    'ngAnimate'
]);
