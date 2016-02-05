<?php

/**
 * Конфигурация модуля
 *
 * @package Shop.Config
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016.02.04
 */
class Shop_Config_General extends Zero_Model
{
    /**
     * URL API К Инвентори
     */
    const URL_API_INVENTORY = 'https://ug.hostkey.ru';

    /**
     * Идентификаторы валют в биллинге
     *
     * @var array
     */
    public static $CurrencyID = [
        'eur' => 2,
    ];

    /**
     * Индексы цен в инвентори (В полученных и закешированных конфигураций)
     *
     * @var array
     */
    public static $CurrencyPrice = [
        'eur' => 'PriceEUR',
    ];
}