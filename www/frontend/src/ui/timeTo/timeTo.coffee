require './jquery.time-to.js'

angular.module "ui.timeTo", []

angular.module("ui.timeTo").directive "timeTo", ->
    restrict: "AE"
    replace: true
    scope:
        date: "=timeTo"
        callback: "&"

    link: (scope, element, attrs, ngModel) ->
        if scope.date
            element.timeTo
                timeTo: new Date(scope.date)
                displayCaptions: true
                captionSize: 8
                countdownAlertLimit: false
                displayDays: 2
                callback: ->
                    element.remove()
                    if attrs.callback
                        scope.$apply(scope.callback())

        else
            element.remove()
