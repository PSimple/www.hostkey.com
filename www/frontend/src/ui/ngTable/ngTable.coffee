require 'bower/ng-table/ng-table.src.js'
require './ngTable.less'

angular.module "ui.ngTable", [
    "ngTable"
]

angular.module("ui.ngTable").run  ->

angular.module("ui.ngTable").run ($templateCache) ->
    tpl =
    """
    <div class="ng-cloak">
        <div ng-if="params.settings().counts.length" class="btn-group pull-right">
            <button ng-repeat="count in params.settings().counts" type="button" ng-class="{'active':params.count()==count}" ng-click="params.count(count)" class="btn btn-default btn-xs"><span ng-bind="count"></span></button>
        </div>
        <ul class="pagination">
            <li ng-class="{'disabled': !page.active}" ng-repeat="page in pages" ng-switch="page.type">
                <a ng-switch-when="prev" ng-click="params.page(page.number)" href="">предыдущая</a>
                <a ng-switch-when="first" ng-click="params.page(page.number)" href=""><span ng-bind="page.number"></span></a>
                <a ng-switch-when="page" ng-click="params.page(page.number)" href=""><span ng-bind="page.number"></span></a>
                <a ng-switch-when="more" ng-click="params.page(page.number)" href="">…</a>
                <a ng-switch-when="last" ng-click="params.page(page.number)" href="">
                <span ng-bind="page.number"></span></a><a ng-switch-when="next" ng-click="params.page(page.number)" href="">следующая</a>
            </li>
        </ul>
    </div>
    """

    $templateCache.put "ng-table/pager.html", tpl
    return