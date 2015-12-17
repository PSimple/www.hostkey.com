require 'angular'
require 'angular-ui-router'
require 'angular-sanitize'

angular.module("config", []).constant("CONFIG", require('webpack-config-loader!../../env/env.js'))

require '../../ui/ui'
require '../../api/api'

require './selected/selected'

angular.module "dedicated.service", [
    "ngSanitize"
    "ui"
    "ui.router"
    "api"

    "dedicated.service.selected"
]

angular.module("dedicated.service").config ($httpProvider, $stateProvider, $urlRouterProvider) ->

    $urlRouterProvider.rule ($injector, $location) ->
        path = $location.path()
        hasTrailingSlash = path[path.length - 1] == '/'
        if hasTrailingSlash
            #if last charcter is a slash, return the same url without the slash
            newPath = path.substr(0, path.length - 1)
            return newPath
        return

    $urlRouterProvider.otherwise ""
    
    $stateProvider
    .state "dedicatedService",
        url: "?currency"
        views:
            "solutions":
                controller: "DedicatedServiceSolutionsCtrl"
                template: require "./solutions.#{country}.jade"
                resolve:
                    solutions: ($solutions) ->
                        $solutions.getList()

    return

angular.module("dedicated.service").run ($stateParams, $state, $rootScope) ->

    $rootScope.$stateParams = $stateParams
    $rootScope.$state = $state

    $rootScope.url = (url) ->
        window.location = url

    $rootScope.bodyClass = ->
        {in: $rootScope.loaded}


angular.module("dedicated.service").controller "DedicatedServiceSolutionsCtrl", ($scope, $state, $stateParams, $rootScope, solutions) ->

    if $stateParams.currency
        window.currency = $stateParams.currency

    $rootScope.loaded = true

    $scope.solutions = solutions