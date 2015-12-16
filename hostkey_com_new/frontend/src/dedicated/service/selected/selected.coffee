window._ = require 'underscore'

angular.module "dedicated.service.selected", []

angular.module("dedicated.service.selected").config ($httpProvider, $stateProvider, $urlRouterProvider) ->

    $stateProvider
    .state "dedicatedService.selected",
        url: "/:type"
        controller: "SelectedCtrl"
        template: require "./selected.jade"
        resolve:
            components: ($dedicated) -> $dedicated.components()
            configCalculator: ($dedicated, $stateParams) -> $dedicated.getConfigCalculator($stateParams.type)
            billingCycleDiscount: ($dedicated) -> $dedicated.billingCycleDiscount()
            solution: ($solutions, $stateParams) -> $solutions.getOne($stateParams.type)

    return

angular.module("dedicated.service.selected").controller "SelectedCtrl", (notifications, $scope, $state, $stateParams, $timeout, configCalculator, billingCycleDiscount, $order, components, solution) ->

    unless configCalculator.Data
        notifications.error configCalculator.Message if configCalculator.Message
        $state.go "^", $stateParams, {reload:true}
        return

    initOrderComponents = (components, config)->
        defaultOrder =
            Currency: window.currency or 'eur'
            Groups: [$stateParams.country, $stateParams.type].join(',')

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

        defaultOrder

    # формируем заказ на сервер
    $scope.order = initOrderComponents(components, configCalculator.Data)

    # выбранное решение
    $scope.solution = solution

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

            RaidLevel:
                options: configCalculator.Data[94]

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
                name: "MS Exchange<br>Cals"
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

            IPv6:
                name: "IPv6 block"


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
        unless order.hardware.hdd.ID.length
            notifications.error "Please choose hard disk!"
            return

        $order.post(order)
        .then (orderLink) ->
            console.log orderLink
            window.location = orderLink

        .catch (error) ->
            if error.Message
                alert error.Message

    $scope.$watch "order.hardware.platform.ID", ->
        watchHdd($scope.tabs, $scope.order)

    $scope.$watch "order.hardware.raid.ID", -> watchRaidLevel($scope.tabs, $scope.order)

    $scope.$watch "order.hardware.cpu", ->
        watchRAM($scope.tabs, $scope.order)
        watchOS($scope.tabs, $scope.order)

    $scope.$watch "tabs.hardware.hdd.selected", ->
        watchHddSelected($scope.tabs, $scope.order)
        watchRaid($scope.tabs, $scope.order)

        watchRaidLevel($scope.tabs, $scope.order)
    , true

    $scope.$watch "order.software.os", -> watchOS($scope.tabs, $scope.order)

    $scope.$watch "order.software.MSExchange.ID", ->
        $scope.order.software.ExchangeCount.Value = 1

    $scope.$watch "order.network.Bandwidth.ID", -> watchTraffic($scope.tabs, $scope.order, configCalculator)

    ###
        Вспомогательные функции контроллера
    ###

    # зависимость Traffic от Bandwidth
    watchTraffic = (tabs, order, config) ->
        trafficOptions = config.Data[14]

        # поиск текущей опции в отфильтрованном списке опций
        findOption = (opt, options) ->
            f = options.filter (o) -> o.ID is opt.ID
            f.length

        # При выборе ”100 Mbps” оставить в поле Traffic (п. 3.1) только “100 mbps Unmetered (26Tb max)”, остальные опции удалить.
        if order.network.Bandwidth.Name is "100Mbps"
            options = trafficOptions.filter (o) -> o.Name is "100Mbps unmetered (26Tb max)"
            unless findOption(order.network.traffic, options)
                $timeout -> order.network.traffic = options[0]
            tabs.network.traffic.options = options
            return

        # При выборе "1Gbps (10)" убираем опцию "100 mbps Unmetered (26Tb max)" в поле Traffic, остальные оставляем.
        if order.network.Bandwidth.Name is "1Gbps"
            options = trafficOptions.filter (o) -> o.Name isnt "100Mbps unmetered (26Tb max)"
            tabs.network.traffic.options = options
            unless findOption(order.network.traffic, options)
                $timeout -> order.network.traffic = options[0]

            return

        # вернем оригинальные варианты опции Traffic
        if trafficOptions.length isnt tabs.network.traffic.options.length
            tabs.network.traffic.options = trafficOptions

        return

    watchRaid = (tabs, order) ->
        # Список зависит от количества выбранных дисков и выбранных “SAS” дисков.
        # Если количество дисков равно или больше “disc” (RAID) либо выбран хотя бы один “SAS” диск.
        # То данный RAID контроллер отображается в списке активным.
        # Иначе он отображается не активным и выбрать его нельзя.
        # В списке присутствует интегрированный RAID контроллер ( Integrated RST RAID 0-10 ) его id = 132.
        # Он стоит первым и становится не доступен, если выбран хотя бы один “SAS” диск.
        findSASDisks = (diskIds) ->
            disks = configCalculator.Data[2]

            filterDisks = disks.filter (d) -> diskIds.indexOf(d.ID) > -1
            filterDisksSAS = filterDisks.filter (d) -> /SAS/.test(d.Name)

            filterDisksSAS.length


        if order.hardware.hdd?.ID
            diskCount = order.hardware.hdd.ID.length

            RaidOptions = configCalculator.Data[8]
            isIncludeSASDisks = findSASDisks(order.hardware.hdd.ID)

            filterRaidOptions = RaidOptions.filter (r) ->
                # исключим интегрированный raid если есть хотя бы один SAS диск
                if isIncludeSASDisks and r.ID is "132"
                    return false

                # исключим интегрированный sas raid если не выбран хотя бы один SAS диск
                if not isIncludeSASDisks and r.ID is "308"
                    return false

                if diskCount >= Number(r.Options.disc, 10) or isIncludeSASDisks
                    return true

            tabs.hardware.raid.options = filterRaidOptions
            $timeout -> order.hardware.raid = filterRaidOptions[0]

        return

    watchRaidLevel = (tabs, order) ->
        # Проверяется поддерживает ли выбранный контроллер очередной уровень “raid” (0,1,5,6,10).
        raidLevels = order.hardware.raid.Options.raid.split("-")
        raidLevels.unshift("-1") # No Raid

        listRaidLevel = configCalculator.Data[94]

        filteredLevels = listRaidLevel.filter (l) -> raidLevels.indexOf(l.ID) > -1

        # Если успешно то происходит проверка на количество выбранных дисков. Смотри список ниже:
        if order.hardware.hdd?.ID
            diskCount = order.hardware.hdd.ID.length

            filteredLevels = listRaidLevel.filter (l) ->
                return l if l.ID is "-1"
                return l if l.ID is "0" and diskCount >= 2
                return l if l.ID is "1" and diskCount >= 2
                return l if l.ID is "5" and diskCount >= 3
                return l if l.ID is "6" and diskCount >= 3
                return l if l.ID is "10" and diskCount >= 4

        # поменяем список RaidLevel на доступные согласно зависимостям
        tabs.hardware.RaidLevel.options = filteredLevels
        $timeout -> order.hardware.RaidLevel = filteredLevels[0]

        return

    # обновим доступные блоки памяти
    watchRAM = (tabs, order)->
        max_mem = order.hardware.cpu.Options.max_mem
        #console.log "watchRAM", order.hardware.cpu.Name, max_mem

        angular.forEach tabs.hardware.ram.options, (opt, optId) ->
            if Number(opt.Options.size, 10) <= Number(max_mem, 10)
                tabs.hardware.ram.options[optId].Options.enable = true
            else
                tabs.hardware.ram.options[optId].Options.enable = false

        #при выборе CPU выбранная память сбрасывается до минимальной
        order.hardware.ram = _.values(tabs.hardware.ram.options)[0]
        return

    watchHdd = (tabs, order) ->
        return unless order.hardware?.platform

        size = order.hardware.platform.Options.size
        # количество дисков
        tabs.hardware.hdd.size = size
        tabs.hardware.hdd.selected = []

        for i in [1..size]
            tabs.hardware.hdd.selected[i-1] = _.values(tabs.hardware.hdd.options)[0]

    watchHddSelected = (tabs, order) ->

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
            ComponentType_ID: "2"
            Options:
                short_name: reduceNames(names)

    #    selectedPlatformSize = Number(order.hardware.platform.Options.size, 10)
    #    if selectedPlatformSize > 8
    #        $.scrollTo '#platform',
    #            offset: -80
    #            duration: 1000

    watchOS = (tabs, order) ->
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

    return


