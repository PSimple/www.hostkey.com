window._ = require 'underscore'

angular.module "dedicated.service.selected", []

angular.module("dedicated.service.selected").config ($httpProvider, $stateProvider, $urlRouterProvider) ->

    $stateProvider
    .state "dedicatedService.selected",
        url: "/selected/:type/:country"
        controller: "MicroCtrl"
        template: require "./selected.jade"
        resolve:
            configCalculator: ($dedicated, $stateParams) ->
                $dedicated.getConfigCalculator($stateParams.type, $stateParams.country)
            billingCycleDiscount: ($dedicated) ->
                $dedicated.billingCycleDiscount()

            raidLevel: ($dedicated) ->
                $dedicated.getRaidLevel()

    return

angular.module("dedicated.service.selected").controller "MicroCtrl", ($scope, $state, $stateParams, $timeout, configCalculator, billingCycleDiscount, raidLevel) ->

    components = {
        1: ['hardware', 'cpu'] # id: ['category', 'name']
        2: ['hardware', 'hdd']
        3: ['hardware', 'ram']
        6: ['hardware', 'platform']
        8: ['hardware', 'raid']

        4: ['software', 'os']
        10: ['software', 'bit']
        5: ['software', 'controlPanel']

        14: ['network', 'traffic']
        7: ['network', 'ip']
        15: ['network', 'vlan']
        19: ['network', 'ftpBackup']

        16: ['sla', 'serviceLevel']
        17: ['sla', 'management']
    }

    initOrderComponents = (components, config)->
        defaultOrder = {}

        angular.forEach components, (component, componentId) ->
            id = componentId
            category = component[0] # категория компонента (hardware, software)
            name = component[1]     # имя компонента (hdd, os)

            if angular.isObject(config[id])
                defaultOrder[category] = {} unless defaultOrder[category]
                defaultOrder[category][name] = _.values(config[id])[0]

            return

        defaultOrder.discount =
            billingCycle: billingCycleDiscount[0]

        defaultOrder.hardware.raidLevel = raidLevel[0]

        defaultOrder

    # формируем заказ на сервер
    $scope.order = initOrderComponents(components, configCalculator)

    unless configCalculator
        alert "Нет конфиграции для #{$stateParams.type} #{$stateParams.country}"
        $state.go "^", $stateParams, {reload:true}
        return

    $timeout ->
        $.scrollTo '#selectedSolution',
            offset: -68
            duration: 1000

    $scope.close = ->
        $.scrollTo('.js-switch-box', 1000)
        $state.go "^", $stateParams, {reload:true}

    $scope.orderPrice = 0

    $scope.$watch "order", () ->
        price = 0
        angular.forEach $scope.order, (group) ->
            angular.forEach group, (opt) ->
                if opt?.Price
                    price += Number(opt.Price)

        $scope.orderPrice = price
    , true

    $scope.tabs =
        hardware:
            open: true
            name: "Hardware"
            cpu:
                name: "CPU"
                options: configCalculator[1]

            platform:
                name: "disks"
                options: configCalculator[6]

            hdd:
                size: 0
                sizeAvailable: [1..8]
                options: configCalculator[2]
            raid:
                options: configCalculator[8]

            raidLevel:
                options: raidLevel

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

    updateHdd = ->
        return unless $scope.order.hardware?.platform

        platform = $scope.order.hardware.platform

        # количество дисков
        $scope.tabs.hardware.hdd.size = platform.Options.size

        return

    updateHdd()

    $scope.buy = -> alert 'buy'

    $scope.$watch "order.hardware.platform", (n, o) ->
        unless angular.equals(n, o)
            updateHdd()
    , true


#    $scope.$watch "order", (n, o) ->
#        unless angular.equals(n, o)
#            console.log "order", n, o
#    , true

