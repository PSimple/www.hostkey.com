<?php

/**
 * Конфигурация запуска консольных задач
 *
 * @package Shop.Config
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016.02.17
 */
class Shop_Config_Console
{
    /**
     * 'ClassName-MethodName' => ['Minute' => 'exp.', 'Hour' => 'exp.', 'Day' => 'exp.', 'Month' => 'exp.', 'Week' => 'exp.', 'IsActive' => 'bool'],
     * exp.: "*", "20", "* /10", "3-8", "6/2", "5,6,7"
     *
     * @var array
     */
    public $Task = [
        /**
         * Кеширование конфигураций калькулятора (Cloud)
         *
         * @see Shop_Cloud_Console_Update
         */
        'Shop_Cloud_Console_Update' => ['Minute' => '*/10', 'Hour' => '*', 'Day' => '*', 'Month' => '*', 'Week' => '*', 'IsActive' => true],
        /**
         * Кеширование конфигураций компонентов по группам для формирования серверов dedicated
         *
         * @see Shop_Dedicated_Console_ConfigCustom
         */
        'Shop_Dedicated_Console_ConfigCustom' => ['Minute' => '*/10', 'Hour' => '*', 'Day' => '*', 'Month' => '*', 'Week' => '*', 'IsActive' => true],
        /**
         * Кеширование стока для доформирования серверов dedicated
         *
         * @see Shop_Dedicated_Console_ConfigStock
         */
        'Shop_Dedicated_Console_ConfigStock' => ['Minute' => '*/10', 'Hour' => '*', 'Day' => '*', 'Month' => '*', 'Week' => '*', 'IsActive' => true],
        /**
         * Кеширование списка компоннетов по типам
         *
         * @see Shop_Dedicated_Console_ConfigList
         */
        'Shop_Dedicated_Console_ConfigList' => ['Minute' => '*/10', 'Hour' => '*', 'Day' => '*', 'Month' => '*', 'Week' => '*', 'IsActive' => true],
    ];
}