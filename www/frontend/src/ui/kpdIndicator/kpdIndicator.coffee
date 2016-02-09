angular.module "ui.kpdIndicator", [
]

angular.module("ui.kpdIndicator").directive "kpdIndicator", ->
    restrict: "AE"
    replace: true
    scope:
        cpuKpd: "="
        cpuCnt: "="
        cpuKpdLink: "="

    template:
        """
        <div class="b-range" ng-repeat="count in Cnt">
            <a ng-href="{{$parent.cpuKpdLink}}" title="Performance per CPU: {{$parent.cpuKpd}}, total: {{$parent.cpuKpd}}" target="_blank">
                <span
                    class="b-range__item"
                    ng-repeat="kpd in $parent.kpdItems"
                    ng-class="{'b-range__item_type_green': $parent.$parent.cpuKpd >= kpd*1500}">
                </span>
            </a>
        </div>
        """

    link: (scope, element, attrs, ngModel) ->

        scope.Cnt = [1..scope.cpuCnt] # количество ядер CPU
        scope.kpdItems = [1..16]       # количество попугаев

#        scope.$watch "cpu.Cnt", (n,o) ->
#            scope.Cnt = [1..scope.cpuCnt]

