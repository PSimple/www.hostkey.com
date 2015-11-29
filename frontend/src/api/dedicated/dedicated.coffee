angular.module "api.dedicated", ['config']

angular.module("api.dedicated").service "$dedicated", ($http, $q, CONFIG) ->
    that = this

    @getConfigCalculator = (type, country)->
        deferred = $q.defer()

        if window.isDev
            url = "/assets/dist/dedicated_#{type}.json"
        else
            url = "#{CONFIG.apiUrl}/dedicated/config"

        if type is "Test"
            groups = type
        else
            groups = [country,type].join(',')

        $http
            url: url
            method: "GET"
            params:
                currency: 'eur'
                groups: groups

        .success (data) ->
            if data.Content

                angular.forEach data.Content.Data, (component, id) ->
                    data.Content.Data[id] = objectToArray(component)

                # у данных компонентов есть значение None
                data.Content.Data[2].unshift(Name: "None")  # hdd
                data.Content.Data[5].unshift(Name: "None")  # controlPanel
                data.Content.Data[12].unshift(Name: "None") # MSSql
                data.Content.Data[20].unshift(Name: "None") # MSExchange
                data.Content.Data[22].unshift(Name: "None") # DDOSProtection
                data.Content.Data[15].unshift(Name: "None") # Vlan
                data.Content.Data[19].unshift(Name: "None") # FtpBackup

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

                deferred.resolve data.Content
            else
                deferred.resolve false

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
                Name: "3 months"
            }
            {
                ID: 3
                Percent: 6
                Period: "semiannually"
                Name: "6 months"
            }
            {
                ID: 4
                Percent: 12
                Period: "annually"
                Name: "1 year"
            }
        ]

        deferred.resolve discount

        deferred.promise

    @getRaidLevel = ->
        deferred = $q.defer()

        discount = [
            {
                ID: 1
                Name: "No Raid"
            }
            {
                ID: 2
                Name: "Stripe(0)"

            }
            {
                ID: 3
                Name: "Mirror(1)"
            }
            {
                ID: 4
                Name: "RAID5"
            }
            {
                ID: 5
                Name: "RAID6"
            }
            {
                ID: 6
                Name: "RAID10"
            }

        ]

        deferred.resolve discount

        deferred.promise

    @components = ->
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
            91:['software', 'RdpLicCount']
            92:['software', 'ExchangeCount']

            14:['network', 'traffic']
            7: ['network', 'ip']
            15:['network', 'vlan']
            18:['network', 'Bandwidth']
            19:['network', 'ftpBackup']
            22:['network', 'DDOSProtection']

            16:['sla', 'serviceLevel']
            17:['sla', 'management']
        }
        components

    that


# преобразовать объект в массив
objectToArray = (object) ->
    arr = []
    angular.forEach object, (c) ->
        arr.push c

    arr
