<?php

/**
 * Получение кеширонной информации по стоковым серверам.
 *
 * Согласно указанным параметрам (группы, валюта)
 * Загружает ранее закешированную конфигурцию
 *
 * @package Shop.Dedicated.Api
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-01-15
 */
class Shop_Dedicated_Api_ConfigStock extends Zero_Controller
{
    /**
     * Получение кеширонной конфигурации для кастомизатора указанного раздела
     *
     * @sample /api/v1/dedicated/config?currency=eur&groups=NL,Mini
     *
     * @return boolean flag статус выполнения
     */
    public function Action_GET()
    {
        if ( !isset($_REQUEST['groups']) || !$_REQUEST['groups'] )
            Zero_App::ResponseJson200(null, -1, ["параметр групп не задан"]);
        else if ( !isset($_REQUEST['currency']) || !$_REQUEST['currency'] )
            Zero_App::ResponseJson200(null, -1, ["параметр валюта не задан"]);

        $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorDedicatedStock/' . md5($_REQUEST['currency'] . $_REQUEST['groups']) . '.data';
        if ( !file_exists($path) )
            Zero_App::ResponseJson200(null, -1, ["файл конфигурации не найден"]);

        $response = unserialize(file_get_contents($path));

        Zero_App::ResponseJson200($response);
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Dedicated_Api_ConfigStock
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
