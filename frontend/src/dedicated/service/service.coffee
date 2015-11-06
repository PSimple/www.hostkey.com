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

angular.module("dedicated.service").controller "DedicatedServiceSolutionsCtrl", ($scope, $rootScope) ->
    $rootScope.loaded = true



