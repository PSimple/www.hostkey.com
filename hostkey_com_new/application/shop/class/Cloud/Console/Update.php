<?php

/**
 * Кеширование конфигураций (Cloud)
 *
 * Запршивает конфигурацию у биллинга.
 * Варианты загрузки для разных валют реализуются здесь в ручную
 *
 * @package Shop.Cloud.Console
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-09-24
 */
class Shop_Cloud_Console_Update extends Zero_Controller
{
    /**
     * Контроллер по умолчанию
     *
     * @return boolean flag статус выполнения
     */
    public function Action_Default()
    {
        $pidList = [530,531,538,539];
        foreach ($pidList as $pid)
        {
            $http = "https://bill.hostkey.com/api/v1.0/shop/proxmox/configcustom?pid={$pid}&currencyId=2";
            $data = Zero_App::RequestJson("GET", $http);
            if ( false == $data['ErrorStatus'] )
            {
                $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorCloudCustom/' . md5('2' . $pid) . '.data';
                Zero_Helper_File::File_Save($path, serialize($data['Content']));
            }
        }
        foreach ($pidList as $pid)
        {
            $http = "https://bill.hostkey.com/api/v1.0/shop/proxmox/configset?pid={$pid}&currencyId=2";
            $data = Zero_App::RequestJson("GET", $http);
            if ( false == $data['ErrorStatus'] )
            {
                $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorCloudSet/' . md5('2' . $pid) . '.data';
                Zero_Helper_File::File_Save($path, serialize($data['Content']));
            }
        }
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Cloud_Console_Update
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
