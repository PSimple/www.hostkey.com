require 'angular'
require 'angular-ui-router'

require '../../ui/ui'
require '../../api/api'

require './selected/selected'

angular.module "dedicated.service", [
    "ui"
    "ui.router"
    "api"

    "dedicated.service.selected"
]

angular.module("dedicated.service").config ($httpProvider, $stateProvider, $urlRouterProvider) ->

    $urlRouterProvider.otherwise ""
    
    $stateProvider
    .state "dedicatedService",
        url: ""
        views:
            "solutions":
                controller: "DedicatedServiceSolutionsCtrl"
                template: require "./solutions.jade"

    return

angular.module("dedicated.service").run ($stateParams, $state, $rootScope) ->

    $rootScope.$stateParams = $stateParams
    return

angular.module("dedicated.service").controller "DedicatedServiceSolutionsCtrl", ($scope, $state, $stateParams, $rootScope) ->

    $rootScope.bodyClass = ->
        {in: $rootScope.loaded}

    $rootScope.loaded = true

    $scope.$stateParams.country = 'NL'

    $scope.changeCountry = (country) ->
        $scope.$stateParams.country = country

        if $state.includes('dedicatedService.selected')
            $state.go $state.current, $stateParams, {reload:true}

