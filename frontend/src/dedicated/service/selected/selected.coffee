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

    return

angular.module("dedicated.service.selected").controller "MicroCtrl", ($scope, $state, $stateParams, $timeout, configCalculator) ->

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
                price += Number(opt.PriceEUR)

        $scope.orderPrice = price
    , true

    # формируем заказ на сервер
    $scope.order =
        hardware:
            cpu: configCalculator[1][230]
            hdd: configCalculator[2][62]
            ram: configCalculator[3][233]

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
                options: configCalculator[1]

