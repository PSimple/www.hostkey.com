<?php

/**
 *  Формирование заказа на новый выделенный сервере
 *
 * Сохранение конфигурации сервера в биллинге.
 * Для дальнейшего оформления заказа на него.
 *
 * @package Shop.Type.Dedicated
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-11-28
 */
class Shop_Type_Dedicated_Order
{
    /**
     * Цена ежемесячного платежа
     *
     * @var float
     */
    public $Price;

    /**
     * Скидка для всего выбранного платежного периода
     *
     * @var float
     */
    public $Discount;

    /**
     * Цена за месяц
     *
     * @var float
     */
    public $PriceMonthly;

    /**
     * Цена за квартал
     *
     * @var float
     */
    public $PriceQuarterly;

    /**
     * Цена за полгода
     *
     * @var float
     */
    public $PriceSemiannually;

    /**
     * Цена за год
     *
     * @var float
     */
    public $PriceAnnually;
}