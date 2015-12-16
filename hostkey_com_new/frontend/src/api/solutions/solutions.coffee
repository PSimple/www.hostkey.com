angular.module "api.solutions", ["config"]

angular.module("api.solutions").service "$solutions", ($http, $q) ->
    that = this

    ###
        Список типовых серверных решений
    ###
    @getList = ->
        deferred = $q.defer()

        type = window.type or 'dedicated'
        country = window.country or 'NL'
        currency = window.currency or 'eur'

        ###
        if window.isDev
            url = "/assets/dist/solutions_#{type}_#{country}.json"
        else
            url = "#{CONFIG.apiUrl}/solutions"
        ###

        $http
            url: "/assets/dist/api/solutions/#{type}/#{country}.json"
            method: "GET"
            cache: true
            params:
                type: type
                country: country
                currency: currency

        .success (data) ->
            deferred.resolve data

        .error (error) ->
            deferred.reject error

        deferred.promise

    @getOne = (type) ->
        deferred = $q.defer()

        that.getList()

        .then (solutions) ->

            solution = solutions.filter (s) -> s.type is type
            if solution.length
                deferred.resolve angular.copy solution[0]
            else
                deferred.resolve {}

        .catch (error) ->
            deferred.reject error

        deferred.promise

    that