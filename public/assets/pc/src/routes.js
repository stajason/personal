/**
 * angularjs路由设置
 */
angular.element(document).ready(function() {
    var controllerPath = '/assets/pc/src/js/controllers/';
    var templatePath = '/assets/pc/src/views/';
    var app = angular.module('webapp');
    app.config(['$routeProvider', '$controllerProvider',
        function($routeProvider, $controllerProvider) {
            var routeMap = {
                '/index': {
                    view : 'pdf-to-img',
                    action : 'PdfController@PdfToImg',
                },
                '/pdf/to/img': {
                    view : 'pdf-to-img',
                    action : 'PdfController@PdfToImg',
                },
            };
            var defaultRoute = '/index';
            for (var key in routeMap) {
                var regexp = /^([a-zA-Z]+)@([a-zA-Z]+)$/;
                var match = routeMap[key].action.match(regexp);
                if (match) {
                    var controller = match[1];
                    var func = match[2];
                    var cpath = controllerPath;
                    $routeProvider.when(key, {
                        templateUrl: templatePath + routeMap[key].view + '.html?v=' + resourceVersion,
                        controller: controller + '_' + func,
                        resolve:{
                            keyName: requireModule(controller, func)
                        }
                    });
                }
            }
            $routeProvider.otherwise({redirectTo: defaultRoute});

            function requireModule(controller, func) {
                return function ($route, $q) {
                    var deferred = $q.defer();
                    if (controllerList[controller] != undefined) {
                        $controllerProvider.register(controller + '_' + func, controllerList[controller][func]);
                        deferred.resolve();
                    }
                    return deferred.promise;
                }
            }
            var $ = jQuery;
        }
    ]);
});
