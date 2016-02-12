<?php

/**
 *  Формирование заказа на новый выделенный сервере
 *
 * Сохранение конфигурации сервера в биллинге.
 * Для дальнейшего оформления заказа на него.
 *
 * @package Shop.Dedicated.Api
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-11-28
 */
class Shop_Dedicated_Api_Order extends Zero_Controller
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
        if ( !isset($_REQUEST['Currency']) || !$_REQUEST['Groups'] )
            Zero_App::ResponseJson200(null, -1, ["параметры групп или валюта не заданы"]);
        settype($_REQUEST['CompId'], 'integer');

        // Получение конфигурации стока
        $responseStock = [];
        if ( 0 < $_REQUEST['CompId'] )
        {
            $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorDedicatedStock/' . str_replace(',', '_', $_REQUEST['Groups']) . '.data';
            if ( !file_exists($path) )
                Zero_App::ResponseJson200(null, -1, ["файл стока не найден"]);
            $responseStock = unserialize(file_get_contents($path));
            if ( !isset($responseStock['Data'][$_REQUEST['CompId']]) )
                Zero_App::ResponseJson200(null, -1, ["стоковый сервер не найден"]);
            $responseStock = $responseStock['Data'][$_REQUEST['CompId']];
            $_REQUEST['Hardware']['Label'] = $responseStock['Cpu']['Name'];
        }

        // Получение конфигурации custom
        $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorDedicated/' . str_replace(',', '_', $_REQUEST['Groups']) . '.data';
        if ( !file_exists($path) )
            Zero_App::ResponseJson200(null, -1, ["файл конфигурации не найден"]);
        $response = unserialize(file_get_contents($path));

        // Индексы валют
        $currencyArr = Shop_Config_General::$CurrencyPrice;

        // Конфигурация
        $label = $_REQUEST['Hardware']['Label'] . '/' . $_REQUEST['Software']['Label'] . '/' . $_REQUEST['Network']['Label'] . '/' . $_REQUEST['SLA']['Label'];
        $label = preg_replace("~\([0-9]+\)~si", "", $label);

        // Расчет по выбранной валюте
        $order = $this->calculate($response['Data'], $responseStock, $currencyArr[$_REQUEST['Currency']]);
        unset($currencyArr[$_REQUEST['Currency']]);

        // Если идет процесс формирования заказа.
        if ( $_REQUEST['Calculation'] )
        {
            Zero_App::ResponseJson200([
                "Summa" => $order->Price,
                "Discount" => $order->Discount,
            ]);
            return true;
        }

        // Расчет по остальным валютам и формирование заказа
        $requestData = [
            'Cycle' => $_REQUEST['SLA']['CycleDiscount'],
            'Monthly' => $order->PriceMonthly,
            'Quarterly' => $order->PriceQuarterly,
            'Semiannually' => $order->PriceSemiannually,
            'Annually' => $order->PriceAnnually,
            'InventoryID' => $_REQUEST['CompId'],
            'Groups' => $_REQUEST['Groups'],
            'CurrencyId' => Shop_Config_General::$CurrencyID[$_REQUEST['Currency']],
        ];
        $result = Zero_App::RequestJson('POST', 'https://bill.hostkey.com/api/v1.0/shop/dedicated/orders', $requestData);
        if ( $result['ErrorStatus'] == false )
        {
            foreach ($currencyArr as $key => $priceIndex)
            {
                $order = $this->calculate($response['Data'], $responseStock, $priceIndex);
                $requestData = [
                    'Cycle' => $_REQUEST['SLA']['CycleDiscount'],
                    'Monthly' => $order->PriceMonthly,
                    'Quarterly' => $order->PriceQuarterly,
                    'Semiannually' => $order->PriceSemiannually,
                    'Annually' => $order->PriceAnnually,
                    'InventoryID' => $_REQUEST['CompId'],
                    'Groups' => $_REQUEST['Groups'],
                    'CurrencyId' => Shop_Config_General::$CurrencyID[$key],
                    'OptionID' => $result['Content']['OptionID'],
                ];
                $result = Zero_App::RequestJson('POST', 'https://bill.hostkey.com/api/v1.0/shop/dedicated/orders', $requestData);
                if ( $result['ErrorStatus'] == true )
                    Zero_App::ResponseJson500($result['Code'], [$result['Message']]);
            }
            Zero_App::ResponseJson200([
                "OptionID" => $result['Content']['OptionID'],
                "Configuration" => $label,
                "currencyId" => Shop_Config_General::$CurrencyID[$_REQUEST['Currency']],
            ]);
        }
        else
        {
            Zero_App::ResponseJson500($result['Code'], [$result['Message']]);
        }
        return true;
    }

    /**
     * Калькулирвоание суммы и скидки заказы в указанной валюте
     *
     * @param array $Calculate
     * @param array $responseStock
     * @param string $currency
     * @return Shop_Dedicated_Api_Order_Type
     */
    private function calculate($Calculate, $responseStock, $currency)
    {
        $order = new Shop_Dedicated_Api_Order_Type();

        // Hardvare
        $costHardware = 0;
        if ( 0 < $_REQUEST['CompId'] )
        {
            $costHardware = $responseStock['Price'][$currency];
        }
        else
        {
            $costHardware += $Calculate[1][$_REQUEST['Hardware']['Cpu']][$currency];
            $costHardware += $Calculate[3][$_REQUEST['Hardware']['Ram']][$currency];
            $costHardware += $Calculate[6][$_REQUEST['Hardware']['Platform']][$currency];
            foreach ($_REQUEST['Hardware']['Hdd'] as $id)
            {
                if ( $id > 0 )
                    $costHardware += $Calculate[2][$id][$currency];
            }
            $costHardware += $Calculate[8][$_REQUEST['Hardware']['Raid']][$currency];
        }
        //        Zero_Logs::File(__FUNCTION__, $costHardvare, $_REQUEST, $Calculate);

        // SoftWare
        $costSoftWare = 0;
        if ( false !== strpos($Calculate[4][$_REQUEST['Software']['OS']]['Name'], 'Windows') )
        {
            $costSoftWare += $Calculate[4][$_REQUEST['Software']['OS']][$currency] * $Calculate[1][$_REQUEST['Hardware']['Cpu']]['Options']['cpu_count'];
        }
        else
        {
            $costSoftWare += $Calculate[4][$_REQUEST['Software']['OS']][$currency];
        }
        $costSoftWare += $Calculate[10][$_REQUEST['Software']['Bit']][$currency];
        // Windows
        if ( isset($_REQUEST['Software']['RdpLicCount']) && $_REQUEST['Software']['RdpLicCount'] > 0 )
        {
            $costSoftWare += $_REQUEST['Software']['RdpLicCount'] * $Calculate[11][138][$currency];
        }
        // Sql
        if ( isset($_REQUEST['Software']['Sql']) && $_REQUEST['Software']['Sql'] > 0 )
        {
            $costSoftWare += $Calculate[12][$_REQUEST['Software']['Sql']][$currency];
        }
        // MS Exchange Cals
        if ( isset($_REQUEST['Software']['Exchange']) && $_REQUEST['Software']['Exchange'] > 0 )
        {
            $costSoftWare += $_REQUEST['Software']['ExchangeCount'] * $Calculate[20][$_REQUEST['Software']['Exchange']][$currency];
        }
        // Unix
        if ( isset($_REQUEST['Software']['CP']) && $_REQUEST['Software']['CP'] > 0 )
        {
            $costSoftWare += $Calculate[5][$_REQUEST['Software']['CP']][$currency];
        }

        // Network
        $costNetwork = 0;
        if ( $_REQUEST['Network']['Traffic'] > 0 )
        {
            $costNetwork += $Calculate[14][$_REQUEST['Network']['Traffic']][$currency];
        }
        if ( $_REQUEST['Network']['Bandwidth'] > 0 )
        {
            $costNetwork += $Calculate[18][$_REQUEST['Network']['Bandwidth']][$currency];
        }
        if ( isset($_REQUEST['Network']['DDOSProtection']) && $_REQUEST['Network']['DDOSProtection'] > 0 )
        {
            $costNetwork += $Calculate[22][$_REQUEST['Network']['DDOSProtection']][$currency];
        }
        if ( $_REQUEST['Network']['IP'] > 0 )
        {
            $costNetwork += $Calculate[7][$_REQUEST['Network']['IP']][$currency];
        }
        if ( isset($_REQUEST['Network']['Vlan']) && $_REQUEST['Network']['Vlan'] > 0 )
        {
            $costNetwork += $Calculate[15][$_REQUEST['Network']['Vlan']][$currency];
        }
        if ( isset($_REQUEST['Network']['FtpBackup']) && $_REQUEST['Network']['FtpBackup'] > 0 )
        {
            $costNetwork += $Calculate[19][$_REQUEST['Network']['FtpBackup']][$currency];
        }

        // SLA
        $costSLA = 0;
        $costSLA += $Calculate[16][$_REQUEST['SLA']['ServiceLevel']][$currency];
        $costSLA += $Calculate[17][$_REQUEST['SLA']['Management']][$currency];
        $costSLA += $Calculate[21][$_REQUEST['SLA']['DCGrade']][$currency] * $Calculate[6][$_REQUEST['Hardware']['Platform']]['Options']['unit'];

        // РАСЧЕТ
        $percentCycle = [
            'monthly' => 0,
            'quarterly' => 3,
            'semiannually' => 6,
            'annually' => 12,
        ];
        // Инофрмация по месяцу для клиента с учетом выбранного периода
        $sum = $costHardware + $costNetwork + $costSLA;
        $discountMonthly = ($sum / 100) * $percentCycle[$_REQUEST['SLA']['CycleDiscount']];
        if ( 0 < $discountMonthly )
            $order->Discount = $discountMonthly * $percentCycle[$_REQUEST['SLA']['CycleDiscount']];
        else
            $order->Discount = $discountMonthly;
        $order->Price = $sum - $discountMonthly + $costSoftWare;
        $order->PriceMonthly = $sum + $costSoftWare;
        $order->PriceQuarterly = ($sum - ($sum * 0.03) + $costSoftWare) * 3;
        $order->PriceSemiannually = ($sum - ($sum * 0.06) + $costSoftWare) * 6;
        $order->PriceAnnually = ($sum - ($sum * 0.12) + $costSoftWare) * 12;
        return $order;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Dedicated_Api_Order
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
