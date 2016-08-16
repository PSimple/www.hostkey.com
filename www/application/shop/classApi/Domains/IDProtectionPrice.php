<?php

/**
 * Получение годовой цены на DNS
 *
 * @package Shop.Api.Domains
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016.05.26
 */
class Shop_Api_Domains_IDProtectionPrice extends Zero_Controller
{
    /**
     * Получение годовой цены на DNS
     *
     * @return boolean flag статус выполнения
     */
    public function Action_GET()
    {
        $http = "https://bill.hostkey.com/api/v1/billing/domains/idprotection/price";
        $data = Zero_App::RequestJson("GET", $http);
        if ( true == $data['ErrorStatus'] || !isset($data['Content']) )
        {
            Zero_App::ResponseJson500(-1, ["Ошибка получение цены DNS"]);
            return false;
        }
        Zero_App::ResponseJson200($data['Content']);
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Api_Domains_IDProtectionPrice
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
