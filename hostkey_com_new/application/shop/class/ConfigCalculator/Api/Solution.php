<?php

/**
 * Получение возможных конфигураций калькуляторов по указанным параметрам
 *
 * @package Shop.ConfigCalculator.Api
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-12-16
 */
class Shop_ConfigCalculator_Api_Solution extends Zero_Controller
{
    /**
     * Получение возможных конфигураций калькуляторов по указанным параметрам
     *
     * @sample /api/v1/solutions?country=RU&currency=eur&type=dedicated
     *
     * @return boolean flag статус выполнения
     */
    public function Action_GET()
    {
        if ( !isset($_REQUEST['country']) || !$_REQUEST['country'] )
            Zero_App::ResponseJson200(null, -1, ["параметр локации не задан"]);
        else if ( !isset($_REQUEST['currency']) || !$_REQUEST['currency'] )
            Zero_App::ResponseJson200(null, -1, ["параметр валюта не задан"]);
        else if ( !isset($_REQUEST['type']) || !$_REQUEST['type'] )
            Zero_App::ResponseJson200(null, -1, ["параметр тип не задан"]);

        $path = '';
        if ( 'dedicated' == $_REQUEST['type'] )
        {
            if ( 'NL' == $_REQUEST['country'] && 'eur' == $_REQUEST['currency'] )
            {
                $path = ZERO_PATH_EXCHANGE . '/NLDED.json';
            }
            else if ( 'RU' == $_REQUEST['country'] && 'eur' == $_REQUEST['currency'] )
            {
                $path = ZERO_PATH_EXCHANGE . '/RUDED.json';
            }
        }

        if ( $path && file_exists($path) )
        {

            echo file_get_contents($path);
            exit;
            Zero_App::ResponseJson200($response);
        }
        else
        {
            Zero_App::ResponseJson500(-1, ['конфигурация не найдена']);
        }

        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_ConfigCalculator_Api_Solution
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
