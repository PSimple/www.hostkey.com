<?php

/**
 * Получение групп зон
 *
 * @package Shop.Api.Domains
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016.05.26
 */
class Shop_Api_Domains_ZoneGroupsList extends Zero_Controller
{
    /**
     * Получение групп зон
     *
     * @return boolean flag статус выполнения
     */
    public function Action_GET()
    {
        $response = Zero_I18n::Model('Shop', 'Zero_DomainsZone Groups options');
        unset($response['Null']);
        Zero_App::ResponseJson200($response);
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Api_Domains_ZoneGroupsList
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
