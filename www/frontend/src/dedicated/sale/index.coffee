require 'angular'
require 'angular-ui-router'
require '../../ui/ui'

require '../../api/api'

angular.module "app.dedicated.sale", [
    "ui"
    "ui.router"
    "api"
]

angular.module("app.dedicated.sale").config ($httpProvider, $stateProvider, $urlRouterProvider) ->

    $urlRouterProvider.otherwise ""
    
    $stateProvider
    .state "sale",
        url: ""
        template: require "./sale.jade"
        controller: "AppDedicatedSaleCtrl"
        resolve:
            configStock: ($dedicated) -> $dedicated.getConfigStock()
            listSort: ->
                [
                    {
                        "ID": "1"
                        "Name": "Price (low -> high)"
                    }
                    {
                        "ID": "2"
                        "Name": "Price (high -> low)"
                    }
                ]


angular.module("app.dedicated.sale").controller "AppDedicatedSaleCtrl", ($state, $stateParams, $scope, $rootScope, configStock, listSort) ->

    $scope.list =
        sort: listSort

    $scope.filter =
        sort: angular.copy listSort[0]

    $rootScope.$stateParams = $stateParams
    $rootScope.$state = $state

    $rootScope.bodyClass = ->
        {in: $rootScope.loaded}

    $rootScope.loaded = true

    $scope.configStock = configStock

    $scope.selectSale = (s) ->

        if s.Id is $scope.selectedSale?.Id
            $scope.selectedSale = null
        else
            $scope.selectedSale = s

