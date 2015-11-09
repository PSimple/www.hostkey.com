angular.module "api.dedicated", [

]

angular.module("api.dedicated").constant("CONFIG", require('webpack-config-loader!../../env/env.js'));

angular.module("api.dedicated").service "$dedicated", ($http, $q, CONFIG) ->
    that = this

    @getConfigCalculator = ->
        deferred = $q.defer()

        $http
            #url: "#{CONFIG.apiUrl}/configcalculator/getconfig?currency=eur&groups=NL,Mini"
            url: "/assets/dist/dedicated.json"
            method: "GET"

        .success (data) ->
            deferred.resolve data.Content

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

    that
