<?php

/**
 * Формирование заказа на стоковый выделенный сервере
 *
 * Сохранение конфигурации сервера в биллинге.
 * Для дальнейшего оформления заказа на него.
 *
 * @package Shop.Dedicated.Api
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-11-28
 */
class Shop_Dedicated_Api_OrderStockFake extends Zero_Controller
{
    /**
     * Формирование заказа.
     *
     * @sample /api/v1/dedicated/order
     *
     * @return boolean flag статус выполнения
     */
    public function Action_POST()
    {
        if ( empty($_REQUEST['os']) || empty($_REQUEST['port']) || empty($_REQUEST['compId']) )
            Zero_App::ResponseJson500(-1, ["параметры для заказа стокового сервера не заданы"]);
        $_REQUEST['SLA']['CycleDiscount'] = 'monthly';
        $_REQUEST['Calculation'] = false;
        $_REQUEST['Groups'] = 'All';

        // Сервер
        $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorDedicatedStock/All.data';
        if ( !file_exists($path) )
            Zero_App::ResponseJson500(-1, ["файл конфигурации стоковых серверов не найден"]);
        $configuration = unserialize(file_get_contents($path));
        $configuration = $configuration['Data'];
        if ( empty($configuration[$_REQUEST['compId']]) )
            Zero_App::ResponseJson500(-1, ["конфигурация стокового сервера не найдена"]);
        $server = $configuration[$_REQUEST['compId']];

        // OS
        $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorList/4.data';
        if ( !file_exists($path) )
            Zero_App::ResponseJson500(-1, ["файл конфигурации os не найден"]);
        $configuration = unserialize(file_get_contents($path));
        if ( empty($configuration[$_REQUEST['os']]) )
            Zero_App::ResponseJson500(-1, ["конфигурация os не найдена"]);
        $os = $configuration[$_REQUEST['os']];

        // PORT
        $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorList/13.data';
        if ( !file_exists($path) )
            Zero_App::ResponseJson500(-1, ["файл конфигурации портов не найдена"]);
        $configuration = unserialize(file_get_contents($path));
        if ( empty($configuration[$_REQUEST['port']]) )
            Zero_App::ResponseJson500(-1, ["конфигурация порта не найдена"]);
        $port = $configuration[$_REQUEST['port']];

        //        $sum = $server['Price']['Price'] + $os['Price'] + $port['Price'];

        // Hardvare
        $costHardware = $server['Price']['PriceEUR'];
        //        $costHardware += $Calculate[1][$_REQUEST['Hardware']['Cpu']]['Price'];
        //        $costHardware += $Calculate[3][$_REQUEST['Hardware']['Ram']]['Price'];
        //        $costHardware += $Calculate[6][$_REQUEST['Hardware']['Platform']]['Price'];
        //        foreach ($_REQUEST['Hardware']['Hdd'] as $id)
        //        {
        //            if ( $id > 0 )
        //                $costHardware += $Calculate[2][$id]['Price'];
        //        }
        //        $costHardware += $Calculate[8][$_REQUEST['Hardware']['Raid']]['Price'];
        $_REQUEST['Hardware']['Label'] = $server['LocationCode'] . '/' . $server['Cpu']['Name'];
        $_REQUEST['Hardware']['Label'] .= '/' . $server['Ram'] . ' GB';
        $_REQUEST['Hardware']['Label'] .= '/' . implode(' + ', $server['Hdd']);

        // SoftWare
        $costSoftWare = $os['PriceEUR'];
        //        if ( false !== strpos($Calculate[4][$_REQUEST['Software']['OS']]['Name'], 'Windows') )
        //        {
        //            $costSoftWare += $Calculate[4][$_REQUEST['Software']['OS']]['Price'] * $Calculate[1][$_REQUEST['Hardware']['Cpu']]['Options']['cpu_count'];
        //        }
        //        else
        //        {
        //            $costSoftWare += $Calculate[4][$_REQUEST['Software']['OS']]['Price'];
        //        }
        //        $costSoftWare += $Calculate[10][$_REQUEST['Software']['Bit']]['Price'];
        //        // Windows
        //        if ( isset($_REQUEST['Software']['RdpLicCount']) && $_REQUEST['Software']['RdpLicCount'] > 0 )
        //        {
        //            $costSoftWare += $_REQUEST['Software']['RdpLicCount'] * $Calculate[11][138]['Price'];
        //        }
        //        // Sql
        //        if ( isset($_REQUEST['Software']['Sql']) && $_REQUEST['Software']['Sql'] > 0 )
        //        {
        //            $costSoftWare += $Calculate[12][$_REQUEST['Software']['Sql']]['Price'];
        //        }
        //        // MS Exchange Cals
        //        if ( isset($_REQUEST['Software']['Exchange']) && $_REQUEST['Software']['Exchange'] > 0 )
        //        {
        //            $costSoftWare += $_REQUEST['Software']['ExchangeCount'] * $Calculate[20][$_REQUEST['Software']['Exchange']]['Price'];
        //        }
        //        // Unix
        //        if ( isset($_REQUEST['Software']['CP']) && $_REQUEST['Software']['CP'] > 0 )
        //        {
        //            $costSoftWare += $Calculate[5][$_REQUEST['Software']['CP']]['Price'];
        //        }
        $_REQUEST['Software']['Label'] = $os['Name'];

        // Network
        $costNetwork = $port['PriceEUR'];
        //        if ( $_REQUEST['Network']['Traffic'] > 0 )
        //        {
        //            $costNetwork += $Calculate[14][$_REQUEST['Network']['Traffic']]['Price'];
        //        }
        //        if ( $_REQUEST['Network']['Bandwidth'] > 0 )
        //        {
        //            $costNetwork += $Calculate[18][$_REQUEST['Network']['Bandwidth']]['Price'];
        //        }
        //        if ( isset($_REQUEST['Network']['DDOSProtection']) && $_REQUEST['Network']['DDOSProtection'] > 0 )
        //        {
        //            $costNetwork += $Calculate[22][$_REQUEST['Network']['DDOSProtection']]['Price'];
        //        }
        //        if ( $_REQUEST['Network']['IP'] > 0 )
        //        {
        //            $costNetwork += $Calculate[7][$_REQUEST['Network']['IP']]['Price'];
        //        }
        //        if ( isset($_REQUEST['Network']['Vlan']) && $_REQUEST['Network']['Vlan'] > 0 )
        //        {
        //            $costNetwork += $Calculate[15][$_REQUEST['Network']['Vlan']]['Price'];
        //        }
        //        if ( isset($_REQUEST['Network']['FtpBackup']) && $_REQUEST['Network']['FtpBackup'] > 0 )
        //        {
        //            $costNetwork += $Calculate[19][$_REQUEST['Network']['FtpBackup']]['Price'];
        //        }
        $_REQUEST['Network']['Label'] = $port['Name'];;

        // SLA
        $costSLA = 0;
        //        $costSLA += $Calculate[16][$_REQUEST['SLA']['ServiceLevel']]['Price'];
        //        $costSLA += $Calculate[17][$_REQUEST['SLA']['Management']]['Price'];
        //        $costSLA += $Calculate[21][$_REQUEST['SLA']['DCGrade']]['Price'] * $Calculate[6][$_REQUEST['Hardware']['Platform']]['Options']['unit'];
        $_REQUEST['SLA']['Label'] = 'None';

        // РАСЧЕТ
        // Инофрмация по месяцу для клиента с учетом выбранного периода
        $sum = $costHardware + $costNetwork + $costSLA;
        // Полная раскладка по месяцам и формирование заказа
        $sumMonthly = $sum + $costSoftWare;
        $sumQuarterly = ($sum - ($sum * 0.03) + $costSoftWare) * 3;
        $sumSemiannually = ($sum - ($sum * 0.06) + $costSoftWare) * 6;
        $sumAnnually = ($sum - ($sum * 0.12) + $costSoftWare) * 12;
        $requestData = [
            'Cycle' => 'monthly',
            'Monthly' => $sumMonthly,
            'Quarterly' => $sumQuarterly,
            'Semiannually' => $sumSemiannually,
            'Annually' => $sumAnnually,
            'InventoryID' => $_REQUEST['compId'],
            'Groups' => $_REQUEST['Groups'],
            'CurrencyId' => 2,
        ];
        $result = Zero_App::RequestJson('POST', 'https://bill.hostkey.com/api/v1.0/shop/dedicated/orders', $requestData);
        $label = $_REQUEST['Hardware']['Label'] . '/' . $_REQUEST['Software']['Label'] . '/' . $_REQUEST['Network']['Label'] . '/' . $_REQUEST['SLA']['Label'];
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
     * @return Shop_Dedicated_Api_OrderStockFake
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
