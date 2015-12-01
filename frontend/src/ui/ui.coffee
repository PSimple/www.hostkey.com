require 'bower/jquery.scrollTo/jquery.scrollTo.js'

require './accordion/accordion'
require './buttons/buttons'
require './scrollBlock/scrollBlock'
require './select2/select2'
require './columns/columns'
require './notifications'

angular.module "ui", [
#    "ui.bootstrap"
    "ui.buttons"
    "ui.scrollBlock"
    "ui.accordion"
    "ui.select"
    "ui.columns"
    "ui.notifications"
]

angular.module("ui").filter 'orderVerbose',  ->
    (obj) ->
        str = ""

        if angular.isObject(obj)
            names = []
            angular.forEach obj, (o) ->
                if o?.Options?.short_name
                    if o.hasOwnProperty('Value')
                        if o.Value > 0
                            count = Number(o.Value, 10)
                            names.push "#{o.Options.short_name}"
                    else
                        names.push o.Options.short_name
                else
                    if o?.Name and o.ID
                        names.push o.Name

            str = names.join(" / ")

        str

angular.module("ui").filter 'discount',  ->
    (price, discountPercent) ->
        discount = discountPercent/100 * price

        price - discount

###
    Расчет полной стоимости компонента с учетом всех зависимостей
    option - опция компонента: OS, Hdd, Ram и тд
    tabs - содержим все вкладки и зависимости опций, если они есть
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

        shortName