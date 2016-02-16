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


angular.module("app.dedicated.sale").controller "AppDedicatedSaleCtrl", (ngTableParams, $filter, $state, $stateParams, $scope, $rootScope, configStock, listSort) ->

    $scope.list =
        sort: listSort

    $scope.filter =
        sort: angular.copy listSort[0]

    $scope.configStock = configStock

    prepareData = (rawArray) ->
        arr = []
        rawArray.forEach (r) ->
            arr.push
                Id: r.Id
                LocationCode: r.LocationCode
                CpuKpd: parseInt(r.Cpu.Kpd, 10)
                CpuName: r.Cpu.Name
                CpuCnt: parseInt(r.Cpu.Cnt, 10)
                CpuKpdLink: r.Cpu.KpdLink
                Ram: parseInt(r.Ram, 10)
                Raid: r.Raid
                Hdd: if r.Hdd then r.Hdd.join("<br>") else ""
                Price: parseInt(r.Price.Price, 10)
                Timer: r.Auction.DateTime
                TimerDiscount: parseInt(r.Auction.Discount, 10)

        arr

    tableData = prepareData(configStock)

    $scope.tableData = new ngTableParams({
        page: 1,
        count: 10
    }, {
        total: configStock.length,
        getData: ($defer, params) ->
            orderedData = if params.sorting() then $filter('orderBy')(tableData, params.orderBy()) else tableData
            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()))
    })

    $rootScope.$stateParams = $stateParams
    $rootScope.$state = $state

    $rootScope.bodyClass = ->
        {in: $rootScope.loaded}

    $rootScope.loaded = true

    $scope.selectSale = (s) ->

        if s.Id is $scope.selectedSale?.Id
            $scope.selectedSale = null
        else
            $scope.selectedSale = s

    # меняем цену сервера когда закончился таймер
    $scope.changePrice = (obj) -> obj.Price = obj.Price + obj.TimerDiscount

