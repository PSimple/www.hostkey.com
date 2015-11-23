###

    div(ng-columns="work_time in model.work_time by 5")
        div(ng-repeat="day in work_time")

###

angular.module "ui.columns", []

angular.module("ui.columns").directive "ngColumns", () ->
    
    slice = (arr, from, len) ->
        arr.slice(from, from + len)

    extract = (obj, path) ->
        parts = path.split('.')
        parts.reduce (memo, key) ->
            memo = memo[key]
        , obj

    transclude: 'element'
    compile: ($elm, $attrs, linker) ->
        ($scope, $elm) ->
            matches = $attrs.ngColumns.match /^([\w\d_"']+) in ([\w\d_"'.]+) by ([\d]+)$/
            parent = $elm.parent()

            makeCols = ->
                parent.html ''
                itemKey = matches[1]
                collection = extract($scope, matches[2])
                itemsPerCol = matches[3]
                colsCount = Math.ceil(collection.length / itemsPerCol)
                for i in [0..colsCount-1]

                    childScope = $scope.$new()
                    childScope[itemKey] = slice collection, i * itemsPerCol, itemsPerCol
                    childScope['$index'] = i
                    childScope['$offset'] = i * itemsPerCol

                    linker childScope, (clone) ->
                        parent.append clone

            $scope.$watch matches[2], makeCols