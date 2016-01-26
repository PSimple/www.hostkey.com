require './dedicated/dedicated'
require './order/order'
require './solutions/solutions'

angular.module "api", [
    "api.dedicated"
    "api.order"
    "api.solutions"
]


angular.module("api").config ($httpProvider) ->

    # Intercept POST requests, convert to standard form encoding
    # $httpProvider.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded"
