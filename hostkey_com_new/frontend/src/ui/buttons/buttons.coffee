require 'bower/angular-bootstrap/ui-bootstrap.js'


angular.module "ui.buttons", [
    "ui.bootstrap.buttons"
]

angular.module("ui.buttons").config (buttonConfig) ->
    buttonConfig.activeClass = "checked"
