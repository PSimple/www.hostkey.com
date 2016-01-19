<?php
/**
 * File Configure Console Controllers
 */
return [
    //  'ClassName-MethodName' => array('Minute' => 'exp.', 'Hour' => 'exp.', 'Day' => 'exp.', 'Month' => 'exp.', 'Week' => 'exp.', 'IsActive' => 'exp.',
    //  expression "*", "20", "*/10", "3-8", "6/2", "5,6,7"
    /**
     * Кеширование конфигураций калькулятора (Cloud)
     *
     * @see Shop_ConfigCalculator_Console_Update
     * @deprecated
     */
    'Shop_Cloud_Console_Update' => [
        'Minute' => '*/10',
        'Hour' => '*',
        'Day' => '*',
        'Month' => '*',
        'Week' => '*',
        'IsActive' => true
    ],
    /**
     * Кеширование конфигураций компонентов по группам для формирования серверов dedicated
     *
     * @see Shop_Dedicated_Console_Update
     */
    'Shop_Dedicated_Console_ConfigCustom' => [
        'Minute' => '*/10',
        'Hour' => '*',
        'Day' => '*',
        'Month' => '*',
        'Week' => '*',
        'IsActive' => true
    ],
    /**
     * Кеширование стока для доформирования серверов dedicated
     *
     * @see Shop_Dedicated_Console_ConfigStock
     */
    'Shop_Dedicated_Console_ConfigStock' => [
        'Minute' => '*/2',
        'Hour' => '*',
        'Day' => '*',
        'Month' => '*',
        'Week' => '*',
        'IsActive' => true
    ],
    /**
     * Кеширование списка компоннетов по типам
     *
     * @see Shop_Dedicated_Console_ConfigList
     */
    'Shop_Dedicated_Console_ConfigList' => [
        'Minute' => '*/2',
        'Hour' => '*',
        'Day' => '*',
        'Month' => '*',
        'Week' => '*',
        'IsActive' => true
    ],
];
