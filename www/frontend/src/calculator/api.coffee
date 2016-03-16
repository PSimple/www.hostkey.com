angular.module("calculator").service "$api", ($http, $filter, $q, CONFIG) ->
    that = this

    @getConfigCalculator = (currency, groups, currencyId, pid, type, country)->
        deferred = $q.defer()

        if window.isDev
            url = "/assets/dist/api/config/#{groups}.json"
        else
            # http://api.hostkey.ru/v1/calc/dedicated?currency=rur&groups=NL,Mini&currencyId=2&pid=234&type=dedicated&country=NL
            #url = "#{CONFIG.apiUrl}/dedicated/config"
            url = "http://api.hostkey.ru/v1/calc/dedicated"

        $http
            url: url
            method: "GET"
            cache: true
            params:
                currency: currency
                groups: groups
                currencyId: currencyId
                pid: pid
                type: type
                country: country

        .success (data) ->
            if data.Content and Number(data.Code, 10) >=0

                angular.forEach data.Content.Data, (component, id) ->
                    data.Content.Data[id] = objectToArray(component)

                ids = [2,5,12,20,22,15,19] # controlPanel, MSSql, MSExchange, DDOSProtection, Vlan, FtpBackup

                for id in ids
                    unless angular.isArray(data.Content.Data[id])
                        data.Content.Data[id] = []

                    data.Content.Data[id].unshift(Name: "None")

                # @todo костыль, нужно в апи менять порядок, чтобы первым был "Integrated RST RAID 0-10"
                # для raid поставить интегрированный рэйд на первое место
                angular.forEach data.Content.Data[8], (raid, i) ->
                    if raid.ID is "132"
                        integrated = raid
                        delete data.Content.Data[8][i]
                        data.Content.Data[8].unshift(integrated)


                data.Content.Data[91] =
                    ComponentType_ID: "91"
                    Name: "RDP Licence"
                    Options:
                        short_name: "RDP Licence"
                    Price: Number(data.Content.CostLicenseWin, 10)
                    Value: 0

                data.Content.Data[92] =
                    Name: "ExchangeCount"
                    Value: 0

                # IPv6
                data.Content.Data[93] =
                    Options:
                        short_name: "IPv6 block"
                    Value: false

                # RaidLevel
                data.Content.Data[94] = that.getRaidLevel()

                data.Content.Currency = currency
                data.Content.Groups = groups

                deferred.resolve data.Content
            else
                deferred.resolve data

        deferred.promise

    @billingCycleDiscount = ->
        deferred = $q.defer()

        discount = [
            {
                ID: 1
                Percent: 0
                Period: "monthly"
                Name: "1 month"
            }
            {
                ID: 2
                Percent: 3
                Period: "quarterly"
                Name: "3 months - 3%"
            }
            {
                ID: 3
                Percent: 6
                Period: "semiannually"
                Name: "6 months - 6%"
            }
            {
                ID: 4
                Percent: 12
                Period: "annually"
                Name: "1 year - 12%"
            }
        ]

        deferred.resolve discount

        deferred.promise

    @getRaidLevel = ->
        [
            {
                ID: "-1"
                Name: "No Raid"
            }
            {
                ID: "0"
                Name: "Stripe(0)"
            }
            {
                ID: "1"
                Name: "Mirror(1)"
            }
            {
                ID: "5"
                Name: "RAID5"
            }
            {
                ID: "6"
                Name: "RAID6"
            }
            {
                ID: "10"
                Name: "RAID10"
            }
        ]

    @components = (type)->
        components = {
            4: ['software', 'os']
            10:['software', 'bit']
            5: ['software', 'controlPanel']
            12:['software', 'MSSql']
            20:['software', 'MSExchange']
            91:['software', 'RdpLicCount']
            92:['software', 'ExchangeCount']

            14:['network', 'traffic']
            7: ['network', 'ip']
            15:['network', 'vlan']
            18:['network', 'Bandwidth']
            19:['network', 'ftpBackup']
            22:['network', 'DDOSProtection']
            93:['network', 'IPv6']

            16:['sla', 'serviceLevel']
            17:['sla', 'management']
            21:['sla', 'DCGrade']
        }

        # hardware опционально
        if type isnt 'sale'
            hardware = {
                1: ['hardware', 'cpu'] # id: ['category', 'name']
                2: ['hardware', 'hdd']
                3: ['hardware', 'ram']
                6: ['hardware', 'platform']
                8: ['hardware', 'raid']
                94: ['hardware', 'RaidLevel']
            }

            components = angular.merge components, hardware

        components


    ###
        преобразуем объект заказа в нужный формат, который понимает метод $order.post()
        используется для расчета стоимости
        - dedicated-серверов
        - sale-серверов (без hardware)
    ###
    @getOrderFormat = (rawOrder) ->

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

    ###
        Посчитать сумму заказа и скидку, без формирования заказа
    ###
    @getOrderPrice = (rawOrder) ->
        deferred = $q.defer()

        if window.isDev
            url = "/assets/dist/api/order/calculation.json"
        else
            url = "#{CONFIG.apiUrl}/dedicated/order"

        that.getOrderFormat(rawOrder)
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

    @postOrder = (rawOrder) ->
        deferred = $q.defer()

        if window.isDev
            url = "/assets/dist/api/order/post.json"
        else
            url = "#{CONFIG.apiUrl}/dedicated/order"

        that.getOrderFormat(rawOrder)
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


# преобразовать объект в массив
objectToArray = (object) ->
    arr = []
    angular.forEach object, (c) ->
        arr.push c

    arr
