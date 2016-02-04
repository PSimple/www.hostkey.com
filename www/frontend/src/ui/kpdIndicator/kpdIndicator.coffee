angular.module "ui.kpdIndicator", [
]

angular.module("ui.kpdIndicator").directive "kpdIndicator", ->
    restrict: "AE"
    replace: true
    scope:
        cpu: "=cpu"

    template:
        """
        <div class="b-range" ng-repeat="count in Cnt">
            <a ng-href="{{$parent.cpu.KpdLink}}" title="Performance per CPU: {{$parent.cpu.Kpd}}, total: {{$parent.cpu.Kpd}}" target="_blank">
                <span
                    class="b-range__item"
                    ng-repeat="kpd in $parent.kpdItems"
                    ng-class="{'b-range__item_type_green': $parent.$parent.cpu.Kpd >= kpd*1500}">
                </span>
            </a>
        </div>
        """

    link: (scope, element, attrs, ngModel) ->
        scope.Cnt = [1..scope.cpu.Cnt] # количество ядер CPU
        scope.kpdItems = [1..16]       # количество попугаев
