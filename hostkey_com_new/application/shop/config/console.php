<?php
/**
 * File Configure Console Controllers
 */
return [
    //  'ClassName-MethodName' => array('Minute' => 'exp.', 'Hour' => 'exp.', 'Day' => 'exp.', 'Month' => 'exp.', 'Week' => 'exp.', 'IsActive' => 'exp.',
    //  expression "*", "20", "*/10", "3-8", "6/2", "5,6,7"
    /**
     * Кеширование конфигураций кастомизатора
     *
     * @see Shop_Console_Dedicated_CustomUpdate
     */
    'Shop_Console_Dedicated_CustomUpdate' => [
        'Minute' => '*/2',
        'Hour' => '*',
        'Day' => '*',
        'Month' => '*',
        'Week' => '*',
        'IsActive' => true
    ],
];
