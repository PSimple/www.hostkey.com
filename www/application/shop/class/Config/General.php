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
    const CURRENCY_EUR = 2;
    const URL_API_INVENTORY = 'https://ug.hostkey.ru';

    public static $CurrencyID = [
        'eur' => 2,
    ];

    public static $CurrencyPrice = [
        'eur' => 'PriceEUR',
    ];
}