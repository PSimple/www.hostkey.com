###

    Анкоры

    jade:
        //- ссылка на анкор
        a(ui-sref="app.portal.agency.structure({'#': 'regions'})") регионах

        //- анкор на который нужно отскролить
        h2.sub-title(anchor="regions") Органы исполнительной
###

angular.module 'ui.anchor', []

angular.module('ui.anchor').directive 'anchor', ($location, $timeout) ->
    scope:
        anchorId: '@anchor'

    link: (scope, element, attrs) ->

        if $location.hash() is scope.anchorId or window.location.search.indexOf(scope.anchorId) > -1
            $timeout ->
                $("html, body").animate
                    scrollTop: element.offset().top - 70
                , 300
            , 1000
