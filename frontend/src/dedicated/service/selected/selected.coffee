window._ = require 'underscore'

angular.module "dedicated.service.selected", []

angular.module("dedicated.service.selected").config ($httpProvider, $stateProvider, $urlRouterProvider) ->

    $stateProvider
    .state "dedicatedService.selected",
        url: "/:country/:type/"
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

angular.module("dedicated.service.selected").controller "MicroCtrl", ($scope, $state, $stateParams, $timeout, configCalculator, billingCycleDiscount, raidLevel, $order) ->

    components = {
        1: ['hardware', 'cpu'] # id: ['category', 'name']
        3: ['hardware', 'ram']
        6: ['hardware', 'platform']
        8: ['hardware', 'raid']

        4: ['software', 'os']
        10:['software', 'bit']
        5: ['software', 'controlPanel']
        12:['software', 'MSSql']
        20:['software', 'MSExchange']

        14:['network', 'traffic']
        7: ['network', 'ip']
        15:['network', 'vlan']
        19:['network', 'ftpBackup']

        16:['sla', 'serviceLevel']
        17:['sla', 'management']
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

    $scope.$watch "order", (n, o) ->
        unless angular.equals(n, o)
            $order.getPrice(n)
            .then (priceData) ->
                $scope.orderPrice = priceData.totalPrice
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
                sizeAvailable: [1..24]
                selected: []
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
                enable: true
                name: "Control Panel"
                options: configCalculator[5]
            MSSql:
                enable: false
                name: "MS SQL"
                options: configCalculator[12]
            MSExchange:
                enable: false
                name: "MS Exchange Cals"
                options: configCalculator[20]
            RDPLicenses:
                enable: false
                value: 0

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

    $scope.buy = ->
        $order.post($scope.order)
        .then (orderLink) ->
            console.log orderLink
#            window.location = orderLink

        .catch (error) ->
            alert "Ошибка формирования заказа"

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
        $scope.order.software.MSExchangeCount = 1

    $scope.$watch "order.software.MSExchangeCount", ->
        if $scope.order.software.MSExchange?.Price
            price = Number($scope.order.software.MSExchange.Price, 10)
            count = Number($scope.order.software.MSExchangeCount, 10)
            $scope.order.software.MSExchange.PriceTotal = price * count

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

    console.log "updateHddSelected", order.hardware.hdd

updateOS = (tabs, order) ->
    multiplicator = 1

    # тригерим опции для винды
    enableWindowsOptions = ->
        tabs.software.controlPanel.enable = false

        tabs.software.MSSql.enable = true
        tabs.software.RDPLicenses.enable = true
        tabs.software.MSExchange.enable = true

        delete order.software.controlPanel

    enableUnixOptions = ->
        tabs.software.controlPanel.enable = true

        tabs.software.MSSql.enable = false
        tabs.software.RDPLicenses.enable = false
        tabs.software.MSExchange.enable = false

        delete order.software.MSSql
        delete order.software.RDPLicenses
        delete order.software.MSExchange


    if /Windows/.test(order.software.os.Name)
        # Если выбрана ОС семейства Windows (п. 2.1) то цена ОС умножается на количество процессоров. параметр ”cpu_count”
        multiplicator = Number(order.hardware.cpu.Options.cpu_count, 10)

        enableWindowsOptions()
    else
        enableUnixOptions()

    price = Number(order.software.os.Price, 10)
    order.software.os.PriceTotal = price * multiplicator


    return


