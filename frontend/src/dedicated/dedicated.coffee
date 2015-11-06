require 'angular'
require 'angular-ui-router'
require '../ui/ui'

require '../api/api'

angular.module "app.dedicated", [
    "ui"
    "ui.router"
    "api"
]

angular.module("app.dedicated").config ($httpProvider, $stateProvider, $urlRouterProvider) ->

    $urlRouterProvider.otherwise ""
    
    $stateProvider
    .state "dedicated",
        url: ""
        views:
            "":
                template: require "./dedicated.jade"
                controller: "AppDedicatedCtrl"
                resolve:
                    dedicated: ($dedicated) ->
                        $dedicated.getOptions()
                     
            "software@":
                template: require "./dedicated.software.jade"
                
            "network@":
                template: require "./dedicated.network.jade"
                
            "contract@":
                template: require "./dedicated.contract.jade"

    return

angular.module("app.dedicated").controller "AppDedicatedCtrl", ($scope, $rootScope, dedicated) ->
    $rootScope.loaded = true

    $scope.orderPrice = 0

    $scope.$watch "order", () ->
        price = 0
        angular.forEach $scope.order, (group) ->
            angular.forEach group, (opt) ->
                price += Number(opt.PriceEUR)

        $scope.orderPrice = price
    , true
    
    # формируем заказ на сервер
    $scope.order =
        software:
            os: dedicated[4][100]
            controlPanel: dedicated[5][113]
            cpu: dedicated[1][230]
        
    $scope.tabs = 
        software:
            open: true
            name: "Software"
            cpu:
                name: "CPU"
                options: dedicated[1]
            os: 
                name: "OS"
                options: dedicated[4]
            controlPanel:
                name: "Control Panel Software"
                options: dedicated[5]

angular.module("app.dedicated").filter 'orderVerbose',  ->
    (obj) ->
        str = ""
        
        if angular.isObject(obj)
            names = []
            angular.forEach obj, (o) ->
                names.push o.Name
                
            str = names.join(" / ")
        
        str
        