window._ = require 'underscore'

angular.module "dedicated.service.selected", []

angular.module("dedicated.service.selected").config ($httpProvider, $stateProvider, $urlRouterProvider) ->

    $stateProvider
    .state "dedicatedService.micro",
        url: "/micro"
        controller: "MicroCtrl"
        template: require "./selected.micro.jade"
        resolve:
            configCalculator: ($dedicated) ->
                $dedicated.getConfigCalculator()
            billingCycleDiscount: ($dedicated) ->
                $dedicated.billingCycleDiscount()

    return

angular.module("dedicated.service.selected").controller "MicroCtrl", ($scope, $state, $stateParams, $timeout, configCalculator, billingCycleDiscount) ->

    $timeout ->
        $('.b-dedicated__hide-block-close').scrollTo(1000)
    , 1000

    $scope.close = ->
        $.scrollTo('.js-switch-box', 1000)
        $state.go "^", $stateParams, {reload:true}

    $scope.orderPrice = 0

    $scope.$watch "order", () ->
        price = 0
        angular.forEach $scope.order, (group) ->
            angular.forEach group, (opt) ->
                if opt.PriceEUR
                    price += Number(opt.PriceEUR)

        $scope.orderPrice = price
    , true

    # формируем заказ на сервер
    $scope.order =
        hardware:
            cpu: _.values(configCalculator[1])[0]
            hdd: _.values(configCalculator[2])[0]
            ram: _.values(configCalculator[3])[0]

        software:
            os: _.values(configCalculator[4])[0]
            bit: _.values(configCalculator[10])[0]
            controlPanel: _.values(configCalculator[5])[0]

        network:
            traffic: _.values(configCalculator[14])[0]
            ip: _.values(configCalculator[7])[0]
            vlan: _.values(configCalculator[15])[0]
            ftpBackup: _.values(configCalculator[19])[0]
        sla:
            serviceLevel: _.values(configCalculator[16])[0]
            management: _.values(configCalculator[17])[0]

        discount:
            billingCycle: billingCycleDiscount[0]

    $scope.tabs =
        hardware:
            open: true
            name: "Hardware"
            cpu:
                name: "CPU"
                options: configCalculator[1]
            hdd:
                name: "disks"
                options: configCalculator[2]
            ram:
                name: "RAM"
                options: configCalculator[3]

        software:
            name: "Software"
            os:
                name: "OS"
                options: configCalculator[4]
            bit:
                name: "Bit"
                options: configCalculator[10]
            controlPanel:
                name: "Control Panel"
                options: configCalculator[5]

        network:
            name: "Network"
            traffic:
                name: "Traffic"
                options: configCalculator[14]
            ip:
                name: "Ip"
                options: configCalculator[7]
            vlan:
                name: "Vlan"
                options: configCalculator[15]
            ftpBackup:
                name: "ftp backup"
                options: configCalculator[19]

        sla:
            name: "SLA"
            serviceLevel:
                name: "service level"
                options: configCalculator[16]
            management:
                name: "management"
                options: configCalculator[17]

        discount:
            billingCycle:
                options: billingCycleDiscount



    $scope.$watch "order", (n, o) ->
        unless angular.equals(n, o)
            console.log "order", n, o
    , true

