angular.module 'api.base', []

angular.module('api.base').config ($httpProvider) ->

    ###
        Для CORS

        На сервере нужны соответствуюзие заголовки

        General
            Request Method:OPTIONS
            Status Code:200 OK
        Response Headers
            ACCESS-CONTROL-ALLOW-HEADERS:Content-Type
            ACCESS-CONTROL-ALLOW-ORIGIN:http://localhost:3000


    ###
    $httpProvider.defaults.useXDomain = true


angular.module('api.base').factory 'API', ($http, $q, $stateParams, CONFIG, $log, $window) ->
    that = this

    basePath = CONFIG.apiUrl

    makeRequest = (verb, uri, data) ->
        defer = $q.defer()
        verb = verb.toLowerCase()

        httpArgs = [ basePath + "/" + uri + "/" ]

        httpArgs.push(data) if verb.match(/post|put/)
        httpArgs.push(params: data) if verb.match(/get/)

        $http[verb].apply(null, httpArgs)

        .success (data) ->
            $log.info "API:#{uri}", data
            defer.resolve data

        .error (data, status) ->
            $log.error "API:#{uri}", data, status
            defer.reject data
            return

        defer.promise


    @get = (uri, params) ->
        makeRequest 'get', uri, params

    @post = (uri, data) ->
        makeRequest 'post', uri, data

    @put = (uri, data) ->
        makeRequest 'put', uri, data

    @delete = (uri, data) ->
        makeRequest 'post', uri


    that
