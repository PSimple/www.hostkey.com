require 'bower/angular-bootstrap/ui-bootstrap.js'

angular.module "ui.accordion", [
    "ui.bootstrap.accordion"
]

angular.module("ui.accordion").config (accordionConfig) ->
    accordionConfig.closeOthers = true

angular.module("ui.accordion").run ($templateCache) ->
    tpl =
        """
            <div class="b-accordion">
                <h3 class="b-accordion__title" ng-class="{'ui-state-active':isOpen}" accordion-transclude="heading" ng-click="toggleOpen()">
                    <span class="b-accordion__title-main" ng-click="toggleOpen()" >
                        {{heading}}
                    </span>
                </h3>
                <div class="b-accordion__item" collapse="!isOpen" ng-transclude>
                </div>
            </div>
        """

    $templateCache.put "template/accordion/accordion-group.html", tpl
    return

angular.module("ui.accordion").run ($templateCache) ->
    tpl =
        """
        <div class="panel-group" ng-transclude></div>
        """

    $templateCache.put "template/accordion/accordion.html", tpl
    return

angular.module("ui.accordion").run ($timeout) ->
    # хак для аккродеона
    # когда расскрывается вкладка, отскроллить на ее заголовок
    $("body").on "click", ".b-accordion__title", (e) ->
        $openedTab = $(this)
        $timeout ->
            $('html, body').animate
                scrollTop: $openedTab.offset().top - 75
            , 150
        , 150