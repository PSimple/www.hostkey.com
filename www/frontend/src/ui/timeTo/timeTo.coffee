require './jquery.timeTo.min.js'

angular.module "ui.timeTo", []

angular.module("ui.timeTo").directive "timeTo", ->
    restrict: "AE"
    replace: true
    scope:
        seconds: "=timeTo"

    link: (scope, element, attrs, ngModel) ->
        seconds = parseInt(scope.seconds, 10)

        if seconds
            element.timeTo
                seconds: seconds
                displayCaptions: true
                captionSize: 8

