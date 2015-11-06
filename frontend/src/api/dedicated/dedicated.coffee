angular.module "api.dedicated", [

]

angular.module("api.dedicated").service "$dedicated", ($http, $q) ->
    that = this

    @getOptions = ->
        deferred = $q.defer()

        $http
            url: "/assets/dist/dedicated.json"
            method: "GET"

        .success (data) ->
            deferred.resolve data.Content

        deferred.promise

    that
