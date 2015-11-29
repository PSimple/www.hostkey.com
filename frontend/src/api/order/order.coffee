angular.module "api.order", ["config"]

angular.module("api.order").service "$order", ($http, $q, $timeout, CONFIG) ->
    that = this

    @getPrice = (order) ->
        deferred = $q.defer()

        # расчет конечной стоимости на стороне клиента
        # @todo переделать на расчет на стороне сервера
        totalPrice = 0
        angular.forEach order, (group) ->
            angular.forEach group, (opt) ->
                if opt?.PriceTotal
                    totalPrice += Number(opt.PriceTotal)
                else
                    if opt?.Price
                        totalPrice += Number(opt.Price)

        price =
            totalPrice: totalPrice
            discount: 10

        $timeout ->
            console.log "order, price", order, price
            deferred.resolve price
        , 500

        deferred.promise

    @post = (order) ->
        deferred = $q.defer()

        fakeOrder =
            Hardware:
                Cpu: 345
                Ram: 345
                Platform: 345
                Hdd: [
                    345
                    345
                    345
                    345
                ]
                Raid: 345
                RaidLevel: 5
            Software:
                OS: 345
                Bit: 345
                RdpLicCount: 2
                Sql: 345
                Exchange: 345
                ExchangeCount: 3
                CP: 345
            Network:
                Traffic: 345
                Bandwidth: 345
                IP: 345
                Vlan: 345
                FtpBackup: 345
            SLA:
                ServiceLevel: 345
                Management: 345
                Comment: "bla bla bla"
                CycleDiscount: "monthly"

        if window.isDev
            url = "/assets/dist/order_post.json"
        else
            url = "#{CONFIG.apiUrl}/configcalculator/order"

        $http
            url: url
            method: if window.isDev then "GET" else "POST"
            data: fakeOrder

        .success (data) ->
            if data.Code is 0 and data.Content

                params =
                    a: "add"
                    currency: window.currencyId
                    pid: window.pid
                    configoption:
                        "600": data.Content.Inventory
                    billingcycle: "quarterly"
                    customfield:
                        "220": data.Content.Configuration

                serializeParams = angular.element.param(params)

                deferred.resolve "https://bill.hostkey.com/cart.php?#{serializeParams}"

            else
                deferred.reject(data)

        deferred.promise

    that