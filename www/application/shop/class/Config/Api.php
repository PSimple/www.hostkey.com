<?php

/**
 * Конфигурация роутинга апи запросов
 *
 * @package Shop.Config
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016.02.17
 */
class Shop_Config_Api
{
    /**
     * 'url' => 'ClassName-MethodName'
     *
     * @var array
     */
    public $Route = [
        /**
         * Получение кеширонной конфигурации для калькулятора Cloud
         *
         * @see Shop_Cloud_Api_Options
         */
        '/api/v1/cloud/options' => ['Controller' => 'Shop_Cloud_Api_Options', 'View' => ''],
        /**
         * Получение возможных конфигураций калькуляторов по указанным параметрам
         *
         * @see Shop_Solution_Api_General
         */
        '/api/v1/solutions' => ['Controller' => 'Shop_Solution_Api_General', 'View' => ''],
        /**
         * Получение кеширонной конфигурации для калькулятора (по группам)
         *
         * @see Shop_Dedicated_Api_Custom
         */
        '/api/v1/dedicated/config' => ['Controller' => 'Shop_Dedicated_Api_Custom', 'View' => ''],
        /**
         * Получение кеширонной информации по стоковым серверам.
         *
         * @see Shop_Dedicated_Api_ConfigStock
         */
        '/api/v1/dedicated/config-stock' => ['Controller' => 'Shop_Dedicated_Api_ConfigStock', 'View' => ''],
        /**
         * Формирование заказа Dedicated
         *
         * @see Shop_Dedicated_Api_Order
         */
        '/api/v1/dedicated/order' => ['Controller' => 'Shop_Dedicated_Api_Order', 'View' => ''],
        /**
         * Формирование заказа на стоковым серверам (временной решение)
         *
         * @see Shop_Dedicated_Api_OrderStockFake
         */
        '/api/v1/dedicated/order-stock-fake' => ['Controller' => 'Shop_Dedicated_Api_OrderStockFake', 'View' => ''],
        /**
         * Формирование заказа на VPS
         *
         * @see Shop_Vps_Api_Order
         */
        '/api/v1/vps/order' => ['Controller' => 'Shop_Vps_Api_Order', 'View' => ''],
    ];
}