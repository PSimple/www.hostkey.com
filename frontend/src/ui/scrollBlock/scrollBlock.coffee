
angular.module "ui.scrollBlock", []

angular.module("ui.scrollBlock").directive "scrollBlock", ->
    restrict: "A"

    link: (scope, element, attrs, ngModel) ->

        scrollBox = $('#scroll-box')
        scrollBlock = $(element)
        $topPositionBox = 0
        $heightScrollBox = 0
        $heightScrollBlock = 0
        $topPositionDocument = 0
        
        countAllPosition = ->
            $topPositionDocument = $(document).scrollTop()
            $topPositionBox = scrollBox.offset().top
            $heightScrollBox = scrollBox.height()
            $heightScrollBlock = scrollBlock.height()
            return
        
        if scrollBox.length
            
            $(window).on 'scroll', ->
                countAllPosition()
                console.log $heightScrollBox, $heightScrollBlock, $topPositionBox

                if $heightScrollBox < $heightScrollBlock
                    console.log "remove is-fixed"
                    scrollBlock.removeClass('is-fixed').removeClass 'is-bottom'
                    return
                    
                if $topPositionDocument >= $topPositionBox - 100
                    console.log scrollBlock, "add"
                    scrollBlock.addClass 'is-fixed'
                else
                    console.log scrollBlock, "remove"
                    scrollBlock.removeClass 'is-fixed'
                    
                if $topPositionDocument > $topPositionBox + $heightScrollBox - $heightScrollBlock - 220
                    scrollBlock.addClass 'is-bottom'
                else
                    scrollBlock.removeClass 'is-bottom'
                    
                return

            countAllPosition()
