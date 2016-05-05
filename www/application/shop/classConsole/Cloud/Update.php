<?php

/**
 * Кеширование конфигураций (Cloud)
 *
 * Запршивает конфигурацию у биллинга.
 * Варианты загрузки для разных валют реализуются здесь в ручную
 *
 * @package Shop.Console.Cloud
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-09-24
 */
class Shop_Console_Cloud_Update extends Zero_Controller
{
    protected $pidList = [530, 531, 538, 539];

    /**
     * Контроллер по умолчанию
     *
     * @return boolean flag статус выполнения
     */
    public function Action_Default()
    {
        $currencyId = Zero_App::$Config->Modules['shop']['currencyId'];
        foreach ($this->pidList as $pid)
        {
            $http = "https://bill.hostkey.com/api/v1/billing/proxmox/options?pid={$pid}&currencyId={$currencyId}";
            $data = Zero_App::RequestJson("GET", $http);
            if ( false == $data['ErrorStatus'] && isset($data['Content']) )
            {
                $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorCloudCustom/' . md5($currencyId . $pid) . '.data';
                Zero_Helper_File::File_Save($path, serialize($data['Content']));
            }
        }
//        foreach ($this->pidList as $pid)
//        {
//            $http = "https://bill.hostkey.com/api/v1.0/shop/proxmox/configset?pid={$pid}&currencyId={$config['currencyId']}";
//            $data = Zero_App::RequestJson("GET", $http);
//            if ( false == $data['ErrorStatus'] && isset($data['Content']) )
//            {
//                $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorCloudSet/' . md5($config['currencyId'] . $pid) . '.data';
//                Zero_Helper_File::File_Save($path, serialize($data['Content']));
//            }
//        }
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Console_Cloud_Update
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
