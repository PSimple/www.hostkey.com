<?php

/**
 * Получение кеширонной конфигурации для кастомизатора (Cloud)
 *
 * Получение кеширонной конфигурации для кастомизатора по указанным параметрам
 * Загружает ранее закешированную конфигурцию
 *
 * В данный момент не используется
 *
 * @package Shop.Cloud.Api
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-11-28
 */
class Shop_Cloud_Api_Options extends Zero_Controller
{
    /**
     * Получение кеширонной конфигурации для кастомизатора указанного раздела
     *
     * @sample /api/v1/cloud/config?pid=530&currencyId=2&custom=1
     *
     * @return boolean flag статус выполнения
     */
    public function Action_GET()
    {
        if ( !isset($_REQUEST['pid']) || !$_REQUEST['pid'] )
            Zero_App::ResponseJson200(null, -1, ["продукт не задан"]);
        else if ( !isset($_REQUEST['currencyId']) || !$_REQUEST['currencyId'] )
            Zero_App::ResponseJson200(null, -1, ["валюта не задана"]);

        if ( $_REQUEST['custom'] )
        {
            $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorCloudCustom/' . md5($_REQUEST['currencyId'] . $_REQUEST['pid']) . '.data';
            if ( !file_exists($path) )
                Zero_App::ResponseJson200(null, -1, ["файл конфигурации не найден"]);

            $response = unserialize(file_get_contents($path));

            Zero_App::ResponseJson200($response);
        }
        else
        {
            Zero_App::ResponseJson200();
        }

        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Cloud_Api_Options
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
