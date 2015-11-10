require 'bower/jquery.scrollTo/jquery.scrollTo.js'

require './accordion/accordion'
require './buttons/buttons'
require './scrollBlock/scrollBlock'
require './select2/select2'

angular.module "ui", [
#    "ui.bootstrap"
    "ui.buttons"
    "ui.scrollBlock"
    "ui.accordion"
    "ui.select"
]

angular.module("ui").filter 'orderVerbose',  ->
    (obj) ->
        str = ""

        if angular.isObject(obj)
            names = []
            angular.forEach obj, (o) ->
                names.push o.Options.short_name

            str = names.join(" / ")

        str

angular.module("ui").filter 'discount',  ->
    (price, discountPercent) ->
        discount = discountPercent/100 * price

        price - discount

