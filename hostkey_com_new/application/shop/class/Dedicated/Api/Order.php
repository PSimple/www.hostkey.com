<?php

/**
 * Сохранение конфигурации сервера в биллинге.
 *
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
     * @sample /api/v1/dedicated/order
     *
     * @return boolean flag статус выполнения
     */
    public function Action_POST()
    {
        if ( !isset($_REQUEST['Currency']) || !$_REQUEST['Groups'] )
            Zero_App::ResponseJson200(null, -1, ["параметры групп или валюта не заданы"]);

        // Получение конфигурации
        $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorDedicated/' . md5($_REQUEST['Currency'] . $_REQUEST['Groups']) . '.data';
        if ( !file_exists($path) )
            Zero_App::ResponseJson200(null, -1, ["файл конфигурации не найден"]);

        $response = unserialize(file_get_contents($path));

        // Расчет
        $sum = 0;
        $Calculate = $response['Data'];
        // Hardvare
        $costHardvare = 0;
        $costHardvare += $Calculate[1][$_REQUEST['Hardware']['Cpu']]['Price'];
        $costHardvare += $Calculate[3][$_REQUEST['Hardware']['Ram']]['Price'];
        $costHardvare += $Calculate[6][$_REQUEST['Hardware']['Platform']]['Price'];
        foreach ($_REQUEST['Hardware']['Hdd'] as $id)
        {
            if ( $id > 0 )
                $costHardvare += $Calculate[2][$id]['Price'];
        }
        $costHardvare += $Calculate[8][$_REQUEST['Hardware']['Raid']]['Price'];
        $sum += $costHardvare;

        // SoftWare
        $costSoftWare = 0;
        $costSoftWare += $Calculate[4][$_REQUEST['Software']['OS']]['Price'];
        $costSoftWare += $Calculate[10][$_REQUEST['Software']['Bit']]['Price'];
        // Windows
        if ( isset($_REQUEST['Software']['RdpLicCount']) && $_REQUEST['Software']['RdpLicCount'] > 0 )
        {
            $costSoftWare += $_REQUEST['Software']['RdpLicCount'] * $Calculate[11][138]['Price'];
        }
        // Sql
        if ( isset($_REQUEST['Software']['Sql']) && $_REQUEST['Software']['Sql'] > 0 )
        {
            $costSoftWare += $Calculate[12][$_REQUEST['Software']['Sql']]['Price'];
        }
        // MS Exchange Cals
        if ( isset($_REQUEST['Software']['Exchange']) && $_REQUEST['Software']['Exchange'] > 0 )
        {
            $costSoftWare += $_REQUEST['Software']['ExchangeCount'] * $Calculate[20][$_REQUEST['Software']['Exchange']]['Price'];
        }
        // Unix
        if ( isset($_REQUEST['Software']['CP']) && $_REQUEST['Software']['CP'] > 0 )
        {
            $costSoftWare += $Calculate[5][$_REQUEST['Software']['CP']]['Price'];
        }
        $sum += $costSoftWare;

        // Network
        $costNetwork = 0;
        if ( $_REQUEST['Network']['Traffic'] > 0 )
        {
            $costNetwork += $Calculate[14][$_REQUEST['Network']['Traffic']]['Price'];
        }
        if ( $_REQUEST['Network']['Bandwidth'] > 0 )
        {
            $costNetwork += $Calculate[18][$_REQUEST['Network']['Bandwidth']]['Price'];
        }
        if ( isset($_REQUEST['Network']['DDOSProtection']) && $_REQUEST['Network']['DDOSProtection'] > 0 )
        {
            $costNetwork += $Calculate[22][$_REQUEST['Network']['DDOSProtection']]['Price'];
        }
        if ( $_REQUEST['Network']['IP'] > 0 )
        {
            $costNetwork += $Calculate[7][$_REQUEST['Network']['IP']]['Price'];
        }
        if ( isset($_REQUEST['Network']['Vlan']) && $_REQUEST['Network']['Vlan'] > 0 )
        {
            $costNetwork += $Calculate[15][$_REQUEST['Network']['Vlan']]['Price'];
        }
        if ( isset($_REQUEST['Network']['FtpBackup']) && $_REQUEST['Network']['FtpBackup'] > 0 )
        {
            $costNetwork += $Calculate[19][$_REQUEST['Network']['FtpBackup']]['Price'];
        }
        $sum += $costNetwork;

        // SLA
        $costSLA = 0;
        $costSLA += $Calculate[16][$_REQUEST['SLA']['ServiceLevel']]['Price'];
        $costSLA += $Calculate[17][$_REQUEST['SLA']['Management']]['Price'];
        $costSLA += $Calculate[21][$_REQUEST['SLA']['DCGrade']]['Price'] * $Calculate[6][$_REQUEST['Hardware']['Platform']]['Options']['unit'];
        $sum += $costSLA;


//        $requestData = [];
//        $requestData['SumEUR'] = $_REQUEST['Hardvare']['Summa'] + $_REQUEST['SoftWare']['Summa'] + $_REQUEST['Network']['Summa'] + $_REQUEST['SLA']['Summa'];
//        $requestData['SumRUR'] = $_REQUEST['Hardvare']['Summa'] + $_REQUEST['SoftWare']['Summa'] + $_REQUEST['Network']['Summa'] + $_REQUEST['SLA']['Summa'];
//        $requestData['billingcycle'] = $_REQUEST['Cicle'];
//        $requestData['InventoryID'] = $_REQUEST['compId'];
//        $requestData['Groups'] = $_REQUEST['Groups'];
//        $requestData['Configuration'] = $_REQUEST['Hardvare']['Label'] . '/' . $_REQUEST['SoftWare']['Label'] . '/' . $_REQUEST['Network']['Label'] .'/' . $_REQUEST['SLA']['Label'];
//        $requestData['Configuration'] = preg_replace("~\([0-9]+\)~si", "", $requestData['Configuration']);



        if ( $_REQUEST['Calculation'] )
        {
            Zero_App::ResponseJson200([
                "Summa" => $sum,
                "Discount" => $sum / 2,
            ]);
            return true;
        }

        // Формирование заказа
        Zero_App::ResponseJson200([
            "Summa" => $sum,
            "Discount" => $sum / 2,
            "OptionID" => 543,
            "Configuration" => "bla bla bla",
        ]);
        return true;
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
