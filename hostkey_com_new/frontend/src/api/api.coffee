require './dedicated/dedicated'
require './order/order'

angular.module "api", [
    "api.dedicated"
    "api.order"
]


angular.module("api").config ($httpProvider) ->

    # Intercept POST requests, convert to standard form encoding
    # $httpProvider.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded"
