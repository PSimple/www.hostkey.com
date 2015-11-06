require 'bower/jquery.scrollTo/jquery.scrollTo.js'

require './accordion/accordion'
require './buttons/buttons'
require './scrollBlock/scrollBlock'

angular.module "ui", [
#    "ui.bootstrap"
    "ui.buttons"
    "ui.scrollBlock"
    "ui.accordion"
]

angular.module("ui").filter 'orderVerbose',  ->
    (obj) ->
        str = ""

        if angular.isObject(obj)
            names = []
            angular.forEach obj, (o) ->
                names.push o.Name

            str = names.join(" / ")

        str