<?php

/**
 * Конфигурация запуска консольных задач
 *
 * @package Shop.Route
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016.02.17
 */
class Shop_Route_Console
{
    /**
     * 'ClassName-MethodName' => ['Minute' => 'exp.', 'Hour' => 'exp.', 'Day' => 'exp.', 'Month' => 'exp.', 'Week' => 'exp.', 'IsActive' => 'bool'],
     * exp.: "*", "20", "* /10", "3-8", "6/2", "5,6,7"
     *
     * @var array
     */
    public $Task = [
        /**
         * Обновление доменных зон
         *
         * @see Shop_Console_Domains_ZoneList
         */
        'Shop_Console_Domains_ZoneList' => ['Minute' => '*/2', 'Hour' => '*', 'Day' => '*', 'Month' => '*', 'Week' => '*', 'IsActive' => true],
        /**
         * Кеширование конфигураций калькулятора (Cloud)
         *
         * @see Shop_Console_Cloud_Update
         */
        'Shop_Console_Cloud_Update' => ['Minute' => '*/30', 'Hour' => '*', 'Day' => '*', 'Month' => '*', 'Week' => '*', 'IsActive' => true],
        /**
         * Кеширование конфигураций компонентов по группам для формирования серверов dedicated
         *
         * @see Shop_Console_Dedicated_ConfigCustom
         */
        'Shop_Console_Dedicated_ConfigCustom' => ['Minute' => '*/30', 'Hour' => '*', 'Day' => '*', 'Month' => '*', 'Week' => '*', 'IsActive' => true],
        /**
         * Кеширование стока для доформирования серверов dedicated
         *
         * @see Shop_Console_Dedicated_ConfigStock
         */
        'Shop_Console_Dedicated_ConfigStock' => ['Minute' => '*/30', 'Hour' => '*', 'Day' => '*', 'Month' => '*', 'Week' => '*', 'IsActive' => true],
        /**
         * Кеширование списка компоннетов по типам
         *
         * @see Shop_Console_Dedicated_ConfigList
         */
        'Shop_Console_Dedicated_ConfigList' => ['Minute' => '*/30', 'Hour' => '*', 'Day' => '*', 'Month' => '*', 'Week' => '*', 'IsActive' => true],
    ];
}