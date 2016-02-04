require 'bower/jquery.scrollTo/jquery.scrollTo.js'

require './accordion/accordion'
require './buttons/buttons'
require './scrollBlock/scrollBlock'
require './select2/select2'
require './columns/columns'
require './notifications/index'
require './anchor/anchor'
require './kpdIndicator/kpdIndicator'
require './timeTo/timeTo'
require './serverCalculator/serverCalculator'


angular.module "ui", [
#    "ui.bootstrap"
    "ui.buttons"
    "ui.scrollBlock"
    "ui.accordion"
    "ui.select"
    "ui.columns"
    "ui.notifications"
    "ui.anchor"
    "ui.kpdIndicator"
    "ui.timeTo"
    "ui.serverCalculator"
]

angular.module("ui").filter 'orderVerbose',  ->
    (obj) ->
        str = ""

        if angular.isObject(obj)
            names = []
            angular.forEach obj, (o) ->
                verboseName = ""

                if o?.Options?.short_name
                    if o.hasOwnProperty('Value')
                        if o.Value > 0
                            count = Number(o.Value, 10)
                            verboseName = "#{o.Options.short_name}"
                    else
                        verboseName = o.Options.short_name
                else
                    if o?.Name and o.ID
                        verboseName = o.Name

                if verboseName
                    # добавить цену в скобках если она больше 0
                    price = Number(o.Price, 10)
                    verboseName += " (#{price})" if price

                    names.push verboseName

            str = names.join(" / ")

        str

angular.module("ui").filter 'discount',  ->
    (price, discountPercent) ->
        discount = discountPercent/100 * price

        price - discount

###
    Расчет полной стоимости компонента с учетом всех зависимостей
    option - опция компонента: OS, Hdd, Ram и тд
    tabs - содержит все вкладки и зависимости опций, если они есть
###
angular.module("ui").filter 'optPrice', ($dedicated) ->
    (option, order, tabs) ->
        unless option?.ComponentType_ID
            return 0

        ComponentType_ID = option?.ComponentType_ID
        price = Number(option.Price, 10)

        # получить параметры опции: зависимости, компонент
        getParams = ->
            components = $dedicated.components()
            component = components[ComponentType_ID]
            optionParams = tabs[component[0]][component[1]]
            optionParams

        ###
            Обработка всех зависимостей расчет цены от выбранной опции компонента
        ###

        # расчет стоимости OS
        if ComponentType_ID is "4"
            # Если выбрана ОС семейства Windows (п. 2.1) то цена ОС умножается на количество процессоров. параметр ”cpu_count”
            if /Windows/.test(option.Name)
                if order.hardware.cpu.Options?.cpu_count
                    multiplicator = Number(order.hardware.cpu.Options.cpu_count, 10)
                else
                    multiplicator = 1

                price = price * multiplicator

        # расчет стоимости MSExchange
        if ComponentType_ID is "20"
            if order.software.ExchangeCount?.Value
                multiplicator = Number(order.software.ExchangeCount.Value, 10)
            else
                multiplicator = 1

            price = price * multiplicator

        # расчет стоимости RdpLicCount
        if ComponentType_ID is "91"
            price = price * Number(option.Value, 10)

        # расчет стоимости DCGrade
        if ComponentType_ID is "21"
            if order.hardware.platform.Options?.unit
                multiplicator = Number(order.hardware.platform.Options.unit, 10)
            else
                multiplicator = 1

            price = price * multiplicator


        price


###
    Расчет полной стоимости компонента с учетом всех зависимостей
    tabs - содержим все вкладки и зависимости опций, если они есть
###
angular.module("ui").filter 'optName',  ->
    (component, tabs) ->
        shortName = ""

        shortName = component.Options.short_name if component?.Options?.short_name

        shortName.replace(/\*/g, "<br>")


angular.module("ui").filter "verboseCurrency", ->
    (price, space) ->
        if space or space is `undefined`
            space = " "
        else
            space = ""

        if window.currency is 'eur'
            return "€#{space}#{price}"

        if window.currency is 'rur'
            # знак ₽ отдельным шрифтом
            # return "#{price}#{space}<span class='rouble'>q</span>"

            # рубль текстом
            return "#{price}#{space}руб."