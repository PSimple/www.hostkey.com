<?php

/**
 *  Формирование заказа на новый выделенный сервере
 *
 * Сохранение конфигурации сервера в биллинге.
 * Для дальнейшего оформления заказа на него.
 *
 * @package Shop.Api.Vps
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-11-28
 */
class Shop_Api_Vps_Order extends Zero_Controller
{
    /**
     * Формирование заказа.
     *
     * Если "Calculation" == true производится только расчет стоимости заказа и скидка
     *
     * @return boolean flag статус выполнения
     */
    public function Action_POST()
    {
        // Проверки
        if ( empty($_REQUEST['period']) || empty($_REQUEST['preset']) || empty($_REQUEST['os']) || empty($_REQUEST['groups']) )
            Zero_App::ResponseJson200(null, -1, ["параметры не заданы"]);

        $configArr = [
            1 => "VPS Win {$_REQUEST['groups']} 1/1/20/IP-1/Traffic-1TB/",
            2 => "VPS Win {$_REQUEST['groups']} 1/2/20/IP-1/Traffic-1TB/",
            3 => "VPS Win {$_REQUEST['groups']} 2/2/40/IP-1/Traffic-1TB/",
            4 => "VPS Win {$_REQUEST['groups']} 2/4/40/IP-1/Traffic-1TB/",
            5 => "VPS Win {$_REQUEST['groups']} 4/4/80/IP-1/Traffic-1TB/",
            6 => "VPS Win {$_REQUEST['groups']} 4/8/80/IP-1/Traffic-1TB/",
        ];
        $configPriceArr = [
            1 => 5,
            2 => 7,
            3 => 10,
            4 => 15,
            5 => 20,
            6 => 30,
        ];

        $label = $configArr[$_REQUEST['preset']] . $_REQUEST['os'];

        $PriceMonthly = $configPriceArr[$_REQUEST['preset']];
        $PriceQuarterly = ($configPriceArr[$_REQUEST['preset']] - ($configPriceArr[$_REQUEST['preset']] * 0.03)) * 3;
        $PriceSemiannually = ($configPriceArr[$_REQUEST['preset']] - ($configPriceArr[$_REQUEST['preset']] * 0.06)) * 6;
        $PriceAnnually = ($configPriceArr[$_REQUEST['preset']] - ($configPriceArr[$_REQUEST['preset']] * 0.12)) * 12;

        // Расчет по остальным валютам и формирование заказа
        $requestData = [
            'Cycle' => $_REQUEST['period'],
            'Monthly' => $PriceMonthly,
            'Quarterly' => $PriceQuarterly,
            'Semiannually' => $PriceSemiannually,
            'Annually' => $PriceAnnually,
            'Label' => $label,
            'Groups' => $_REQUEST['groups'],
            'CurrencyId' => 2,
        ];

        $result = Zero_App::RequestJson('POST', 'https://bill.hostkey.com/api/v1.0/shop/vps/orders', $requestData);
        if ( $result['ErrorStatus'] == false )
        {
            Zero_App::ResponseJson200([
                "OptionID" => $result['Content']['OptionID'],
                "Configuration" => $label,
                "currencyId" => 2,
            ]);
        }
        else
        {
            Zero_App::ResponseJson500($result['Code'], [$result['Message']]);
        }
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Vps_Api_Order
     */
    public static function Make($properties = [])
    {
        $Controller = new self();
        foreach ($properties as $property => $value)
        {
            $Controller->Params[$property] = $value;
        }
        return $Controller;
    }
}
