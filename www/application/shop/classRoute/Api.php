<?php

/**
 * Конфигурация роутинга апи запросов
 *
 * @package Shop.Route
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016.02.17
 */
class Shop_Route_Api
{
    /**
     * 'url' => 'ClassName-MethodName'
     *
     * @var array
     */
    public $Route = [
        /**
         * Получение годовой цены на DNS
         *
         * @see Shop_Api_Domains_DnsPrice
         */
        '/api/v1/shop/domains/dns/price' => ['Controller' => 'Shop_Api_Domains_DnsPrice', 'View' => ''],
        /**
         * Получение групп зон
         *
         * @see Shop_Api_Domains_ZoneGroupsList
         */
        '/api/v1/shop/domains/zone/groups/list' => ['Controller' => 'Shop_Api_Domains_ZoneGroupsList', 'View' => ''],
        /**
         * Проверка нескольких доменов по указзанной группе зон
         *
         * @see Shop_Api_Domains_CheckGroups
         */
        '/api/v1/shop/domains/check/groups' => ['Controller' => 'Shop_Api_Domains_CheckGroups', 'View' => ''],
        /**
         * Проверка одного домена
         *
         * @see Shop_Api_Domains_CheckOne
         */
        '/api/v1/shop/domains/check/one' => ['Controller' => 'Shop_Api_Domains_CheckOne', 'View' => ''],
        /**
         * Проверка нескольких доменов
         *
         * @see Shop_Api_Domains_Check
         */
        '/api/v1/shop/domains/check' => ['Controller' => 'Shop_Api_Domains_Check', 'View' => ''],
        /**
         * Получение списка зон по указанной группе
         *
         * @see Shop_Api_Domains_ZoneList
         */
        '/api/v1/shop/domains/zone/list' => ['Controller' => 'Shop_Api_Domains_ZoneList', 'View' => ''],
        /**
         * Получение кеширонной конфигурации для калькулятора Cloud
         *
         * @see Shop_Api_Cloud_Options
         */
        '/api/v1/cloud/options' => ['Controller' => 'Shop_Api_Cloud_Options', 'View' => ''],
        /**
         * Получение возможных конфигураций калькуляторов по указанным параметрам
         *
         * @see Shop_Api_Solution_General
         */
        '/api/v1/solutions' => ['Controller' => 'Shop_Api_Solution_General', 'View' => ''],
        /**
         * Получение кеширонной конфигурации для калькулятора (по группам)
         *
         * @see Shop_Api_Dedicated_Custom
         */
        '/api/v1/dedicated/config' => ['Controller' => 'Shop_Api_Dedicated_Custom', 'View' => ''],
        /**
         * Получение кеширонной информации по стоковым серверам.
         *
         * @see Shop_Api_Dedicated_ConfigStock
         */
        '/api/v1/dedicated/config-stock' => ['Controller' => 'Shop_Api_Dedicated_ConfigStock', 'View' => ''],
        /**
         * Формирование заказа Dedicated
         *
         * @see Shop_Api_Dedicated_Order
         */
        '/api/v1/dedicated/order' => ['Controller' => 'Shop_Api_Dedicated_Order', 'View' => ''],
        /**
         * Формирование заказа на стоковым серверам (временной решение)
         *
         * @see Shop_Api_Dedicated_OrderStockFake
         */
        '/api/v1/dedicated/order-stock-fake' => ['Controller' => 'Shop_Api_Dedicated_OrderStockFake', 'View' => ''],
        /**
         * Формирование заказа на VPS
         *
         * @see Shop_Api_Vps_Order
         */
        '/api/v1/vps/order' => ['Controller' => 'Shop_Api_Vps_Order', 'View' => ''],
    ];
}