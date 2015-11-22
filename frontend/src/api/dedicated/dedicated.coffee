angular.module "api.dedicated", [

]

angular.module("api.dedicated").constant("CONFIG", require('webpack-config-loader!../../env/env.js'));

angular.module("api.dedicated").service "$dedicated", ($http, $q, CONFIG) ->
    that = this

    @getConfigCalculator = (type, country)->
        deferred = $q.defer()

        if location.host is 'hostkey'
            url = "/assets/dist/dedicated_#{type}.json"
        else
            url = "#{CONFIG.apiUrl}/configcalculator/getconfig"

        $http
            url: url
            method: "GET"
            params:
                currency: 'eur'
                groups: [country,type].join(',')

        .success (data) ->
            if data.Content

                # control panel default value
                data.Content.Data[5][0] =
                    Name: "None"

                deferred.resolve data.Content.Data
            else
                deferred.resolve false

        deferred.promise

    @billingCycleDiscount = ->
        deferred = $q.defer()

        discount = [
            {
                ID: 1
                Value: 0
                Name: "1 month"
            }
            {
                ID: 2
                Value: 3
                Name: "3 months"
            }
            {
                ID: 3
                Value: 6
                Name: "6 months"
            }
            {
                ID: 4
                Value: 12
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

    that
