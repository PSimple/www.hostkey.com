require 'bower/select2/dist/css/select2.css'
require 'bower/select2/dist/js/select2.full.js'

angular.module "ui.select", [
]

angular.module("ui.select").directive "select2", ($timeout) ->
    restrict: "AC"
    scope:
        model: "=select2"

    link: (scope, element, attrs, ngModel) ->

        $timeout ->
            element.select2()

            element.bind "change", ->
                console.log "change", element.select2('data'), JSON.parse(element.select2('val'))

                scope.$apply ->
                    scope.model = JSON.parse(element.select2('val'))


angular.module("ui.select").directive "uiSelect",  ->
    restrict: "AC"
    scope:
        uiSelect: "="
        options: "="
        width: "@"

    template:
        """
            <select select2="uiSelect" ng-style="{width: width+'px'}">
                <option ng-selected="{{item.ID === uiSelect.ID}}" ng-repeat="item in options" value="{{item}}">{{item.Name}}</option>
            </select>
        """

