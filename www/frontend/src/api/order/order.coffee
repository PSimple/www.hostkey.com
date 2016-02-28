angular.module "api.order", ["config"]

angular.module("api.order").service "$order", ($http, $q, $timeout, CONFIG, $filter) ->
    that = this

    ###
        Посчитать сумму заказа и скидку, без формирования заказа
    ###
    @getPrice = (rawOrder) ->
        deferred = $q.defer()

        if window.isDev
            url = "/assets/dist/api/order/calculation.json"
        else
            url = "#{CONFIG.apiUrl}/dedicated/order"

        that.orderFormat(rawOrder)
        .then (order) ->
            order.Calculation = true

            $http
                url: url
                method: if window.isDev then "GET" else "POST"
                data: order

            .success (data) ->
                if data.Code is 0
                    deferred.resolve data.Content
                else
                    deferred.reject data

            .error (data) ->
                deferred.reject data

        deferred.promise

    ###
        преобразуем объект заказа в нужный формат, который понимает метод $order.post()
        используется для расчета стоимости
        - dedicated-серверов
        - sale-серверов (без hardware)
    ###
    @orderFormat = (rawOrder) ->

        deferred = $q.defer()

        rawOrder = angular.copy(rawOrder)

        order = {}

        if rawOrder.hardware
            order.Hardware =
                Cpu: rawOrder.hardware.cpu.ID
                Ram: rawOrder.hardware.ram.ID
                Platform: rawOrder.hardware.platform.ID
                Hdd: rawOrder.hardware.hdd.ID
                Raid: rawOrder.hardware.raid.ID
                RaidLevel: rawOrder.hardware.RaidLevel.ID
                Label: $filter('orderVerbose')(rawOrder.hardware)

        if rawOrder.software
            order.Software = {}
            order.Software.OS = rawOrder.software.os.ID if rawOrder.software?.os
            order.Software.Bit = rawOrder.software.bit.ID if rawOrder.software?.bit
            order.Software.CP = rawOrder.software.controlPanel?.ID if rawOrder.software?.controlPanel
            order.Software.RdpLicCount = Number(rawOrder.software.RdpLicCount.Value, 10) if rawOrder.software?.RdpLicCount
            order.Software.Sql = rawOrder.software.MSSql?.ID if rawOrder.software?.MSSql
            order.Software.Exchange = rawOrder.software.MSExchange?.ID if rawOrder.software?.MSExchange
            order.Software.ExchangeCount = Number(rawOrder.software.ExchangeCount.Value, 10) if rawOrder.software?.ExchangeCount
            order.Software.Label = $filter('orderVerbose')(rawOrder.software)

        if rawOrder.network
            order.Network = {}
            order.Network.Traffic = rawOrder.network.traffic.ID if rawOrder.network?.traffic
            order.Network.Bandwidth = rawOrder.network.Bandwidth.ID if rawOrder.network?.Bandwidth
            order.Network.DDOSProtection = rawOrder.network.DDOSProtection.ID if rawOrder.network?.DDOSProtection
            order.Network.IP = rawOrder.network.ip.ID if rawOrder.network?.ip
            order.Network.Vlan = rawOrder.network.vlan.ID if rawOrder.network?.vlan
            order.Network.FtpBackup = rawOrder.network.ftpBackup.ID if rawOrder.network?.ftpBackup
            order.Network.IPv6 = rawOrder.network.IPv6.Value if rawOrder.network?.IPv6
            order.Network.Label = $filter('orderVerbose')(rawOrder.network)

        if rawOrder.sla
            order.SLA = {}
            order.SLA.ServiceLevel = rawOrder.sla.serviceLevel.ID if rawOrder.sla?.serviceLevel
            order.SLA.Management = rawOrder.sla.management.ID  if rawOrder.sla?.management
            order.SLA.DCGrade = rawOrder.sla.DCGrade.ID if rawOrder.sla?.DCGrade
            order.SLA.Comment = ""
            order.SLA.CycleDiscount = rawOrder.discount.billingCycle.Period
            order.SLA.Label = $filter('orderVerbose')(rawOrder.sla)

        if rawOrder.sla
            order.Currency = rawOrder.Currency

        if rawOrder.Groups
            order.Groups = rawOrder.Groups

        if rawOrder.CompId
            order.CompId = rawOrder.CompId

        deferred.resolve order

        deferred.promise

    @post = (rawOrder) ->
        deferred = $q.defer()

        if window.isDev
            url = "/assets/dist/api/order/post.json"
        else
            url = "#{CONFIG.apiUrl}/dedicated/order"

        that.orderFormat(rawOrder)
        .then (order) ->
            # формируем заказ
            order.Calculation = false

            $http
                url: url
                method: if window.isDev then "GET" else "POST"
                data: order

            .success (data) ->
                if data.Code is 0 and data.Content

                    params =
                        a: "add"
                        currency: window.currencyId
                        pid: window.pid
                        configoption:
                            "600": data.Content.OptionID
                        billingcycle: order.SLA.CycleDiscount
                        customfield:
                            "220": data.Content.Configuration

                    serializeParams = angular.element.param(params)

                    deferred.resolve "https://bill.hostkey.com/cart.php?#{serializeParams}"

                else
                    deferred.reject(data)

        deferred.promise

    that