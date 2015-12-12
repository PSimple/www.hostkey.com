require 'bower/select2/dist/css/select2.css'
require 'bower/select2/dist/js/select2.full.js'

angular.module "ui.select", [
]

angular.module("ui.select").directive "select2", ($timeout) ->
    restrict: "AC"
    scope:
        model: "=select2"

    link: (scope, element, attrs, ngModel) ->

        scope.$watch "model", (n, o) ->
            unless angular.equals(n, o)
                newModel = angular.copy n
                element.select2().val(JSON.stringify(newModel)).trigger("change") unless scope.$$phase
        , true

        $timeout ->
            element.select2()

            element.bind "change", ->
                $timeout ->
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
                <option ng-selected="{{item.ID === uiSelect.ID}}" ng-repeat="item in options" value="{{item}}">{{item|itemPrice}}</option>
            </select>
        """

angular.module("ui.select").filter "itemPrice",  ->
    (item) ->
        str = item.Name
        price = Number(item.Price, 10)
        str += " (#{price})" if price

        str