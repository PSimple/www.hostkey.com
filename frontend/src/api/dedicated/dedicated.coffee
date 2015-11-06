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

    that
