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

    @components = ->
        components = {
            1: ['hardware', 'cpu'] # id: ['category', 'name']
            3: ['hardware', 'ram']
            6: ['hardware', 'platform']
            8: ['hardware', 'raid']
            94: ['hardware', 'RaidLevel']

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
        components

    that


# преобразовать объект в массив
objectToArray = (object) ->
    arr = []
    angular.forEach object, (c) ->
        arr.push c

    arr
