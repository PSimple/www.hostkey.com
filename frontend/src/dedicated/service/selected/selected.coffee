window._ = require 'underscore'

angular.module "dedicated.service.selected", []

angular.module("dedicated.service.selected").config ($httpProvider, $stateProvider, $urlRouterProvider) ->

    $stateProvider
    .state "dedicatedService.selected",
        url: "/:country/:type/"
        controller: "MicroCtrl"
        template: require "./selected.jade"
        resolve:
            components: ($dedicated) -> $dedicated.components()

            configCalculator: ($dedicated, $stateParams) ->
                $dedicated.getConfigCalculator($stateParams.type, $stateParams.country)
            billingCycleDiscount: ($dedicated) ->
                $dedicated.billingCycleDiscount()

            raidLevel: ($dedicated) ->
                $dedicated.getRaidLevel()

    return

angular.module("dedicated.service.selected").controller "MicroCtrl", ($scope, $state, $stateParams, $timeout, configCalculator, billingCycleDiscount, raidLevel, $order, components) ->

    initOrderComponents = (components, config)->
        defaultOrder = {}

        angular.forEach components, (component, componentId) ->
            id = componentId
            category = component[0] # категория компонента (hardware, software)
            name = component[1]     # имя компонента (hdd, os)

            defaultOrder[category] = {} unless defaultOrder[category]
            # массив значений в опции компонента
            if angular.isArray(config[id])
                defaultOrder[category][name] = config[id][0]
            else
                # числовое значение в опции компонента
                defaultOrder[category][name] = config[id]

            return

        defaultOrder.discount =
            billingCycle: billingCycleDiscount[0]

        defaultOrder.hardware.raidLevel = raidLevel[0]

        defaultOrder

    # формируем заказ на сервер
    $scope.order = initOrderComponents(components, configCalculator.Data)

    unless configCalculator.Data
        alert "Нет конфиграции для #{$stateParams.type} #{$stateParams.country}"
        $state.go "^", $stateParams, {reload:true}
        return

    $scope.close = ->
        $.scrollTo('.js-switch-box', 1000)
        $state.go "^", $stateParams, {reload:true}

    # объект с суммой заказа и скидкой
    $scope.totalPrice = {}

    $scope.$watch "order", (n, o) ->
        unless angular.equals(n, o)
            $order.getPrice(n)
            .then (totalPrice) ->
                $scope.totalPrice = totalPrice
    , 3000

    $scope.tabs =
        hardware:
            name: "Hardware"
            cpu:
                name: "CPU"
                options: configCalculator.Data[1]

            platform:
                name: "disks"
                options: configCalculator.Data[6]

            hdd:
                size: 0
                sizeAvailable: [1..24]
                selected: []
                options: configCalculator.Data[2]

            raid:
                options: configCalculator.Data[8]

            raidLevel:
                options: raidLevel

            ram:
                name: "RAM"
                options: configCalculator.Data[3]

        software:
            name: "Software"
            os:
                name: "OS"
                options: configCalculator.Data[4]
            bit:
                name: "Bit"
                options: configCalculator.Data[10]
            controlPanel:
                enable: true
                name: "Control Panel"
                options: configCalculator.Data[5]
            MSSql:
                enable: false
                name: "MS SQL"
                options: configCalculator.Data[12]
            MSExchange:
                enable: false
                name: "MS Exchange Cals"
                options: configCalculator.Data[20]
            RdpLicCount:
                name: "RDP<br>Licenses"
                enable: false

        network:
            name: "Network"
            traffic:
                name: "Traffic"
                options: configCalculator.Data[14]
            Bandwidth:
                name: "Bandwidth"
                options: configCalculator.Data[18]
            ip:
                name: "Ip"
                options: configCalculator.Data[7]
            vlan:
                name: "Vlan"
                options: configCalculator.Data[15]
            ftpBackup:
                name: "ftp backup"
                options: configCalculator.Data[19]

            DDOSProtection:
                name: "DDOS Protection"
                options: configCalculator.Data[22]

        sla:
            name: "SLA"
            serviceLevel:
                name: "Service level agreement"
                options: configCalculator.Data[16]
            management:
                name: "Management"
                options: configCalculator.Data[17]
            DCGrade:
                name: "DC grade"
                options: configCalculator.Data[21]

        discount:
            billingCycle:
                name: "Billing cycle discount:"
                options: billingCycleDiscount

    $scope.isValidOption = (opt) ->
        return false unless opt.Options?.short_name

        if opt.hasOwnProperty('Value')
            if opt.Value > 0
                return true
        else
            if opt.hasOwnProperty('ID')
                return true

    $timeout ->
        $.scrollTo '#selectedSolution',
            offset: -68
            duration: 1000
        $timeout ->
            $scope.tabs.hardware.open = true
        , 1000

    $scope.buy = (order) ->
        $order.post(order)
        .then (orderLink) ->
            alert orderLink
            console.log orderLink
            #window.location = orderLink

        .catch (error) ->
            if error.Message
                alert error.Message

    $scope.$watch "order.hardware.platform.ID", ->
        updateHdd($scope.tabs, $scope.order)

    $scope.$watch "order.hardware.cpu", ->
        updateRAM($scope.tabs, $scope.order)
        updateOS($scope.tabs, $scope.order)

    $scope.$watch "tabs.hardware.hdd.selected", ->
        updateHddSelected($scope.tabs, $scope.order)
    , true

    $scope.$watch "order.software.os", -> updateOS($scope.tabs, $scope.order)

    $scope.$watch "order.software.MSExchange.ID", ->
        $scope.order.software.ExchangeCount.Value = 1

# обновим доступные блоки памяти
updateRAM = (tabs, order)->
    max_mem = order.hardware.cpu.Options.max_mem
    console.log "updateRAM", order.hardware.cpu.Name, max_mem

    angular.forEach tabs.hardware.ram.options, (opt, optId) ->
        if Number(opt.Options.size, 10) <= Number(max_mem, 10)
            tabs.hardware.ram.options[optId].Options.enable = true
        else
            tabs.hardware.ram.options[optId].Options.enable = false

    #при выборе CPU выбранная память сбрасывается до минимальной
    order.hardware.ram = _.values(tabs.hardware.ram.options)[0]
    return

updateHdd = (tabs, order) ->
    return unless order.hardware?.platform

    size = order.hardware.platform.Options.size
    # количество дисков
    tabs.hardware.hdd.size = size
    tabs.hardware.hdd.selected = []

    for i in [1..size]
        tabs.hardware.hdd.selected[i-1] = _.values(tabs.hardware.hdd.options)[0]

updateHddSelected = (tabs, order) ->

    price = 0
    hddCount = 0
    names = {}
    ids = []

    angular.forEach tabs.hardware.hdd.selected, (hdd) ->
        # пропустим None и невалидные опции
        return unless hdd?.Options or hdd?.Price

        price += Number(hdd.Price, 10)
        hddCount++

        name = hdd.Options.short_name
        if names[name]
            names[name]++
        else
            names[name] = 1

        ids.push hdd.ID

    reduceNames = (names) ->
        short_name = []

        angular.forEach names, (count, name) ->
            if count > 1
                short_name.push "#{count}x#{name}"
            else
                short_name.push name

        short_name.join("*")

    order.hardware.hdd =
        ID: ids
        Price: price
        Options:
            short_name: reduceNames(names)

#    selectedPlatformSize = Number(order.hardware.platform.Options.size, 10)
#    if selectedPlatformSize > 8
#        $.scrollTo '#platform',
#            offset: -80
#            duration: 1000

updateOS = (tabs, order) ->
    # тригерим опции для винды
    enableWindowsOptions = ->
        tabs.software.controlPanel.enable = false

        tabs.software.MSSql.enable = true
        tabs.software.RdpLicCount.enable = true
        tabs.software.MSExchange.enable = true

        order.software.controlPanel = Name: "None"

    enableUnixOptions = ->
        tabs.software.controlPanel.enable = true

        tabs.software.MSSql.enable = false
        tabs.software.RdpLicCount.enable = false
        tabs.software.MSExchange.enable = false

        order.software.MSSql = Name: "None"
        order.software.MSExchange = Name: "None"
        order.software.RdpLicCount.Value = 0
        order.software.ExchangeCount.Value = 0

    if /Windows/.test(order.software.os.Name)
        enableWindowsOptions()
    else
        enableUnixOptions()

    return

