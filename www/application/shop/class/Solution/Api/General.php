<?php

/**
 * Получение возможных конфигураций калькуляторов по указанным параметрам
 *
 * @package Shop.Solution.Api
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-02-04
 */
class Shop_Solution_Api_General extends Zero_Controller
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
            Zero_App::ResponseJson500(-1, ["параметр локации не задан"]);
        else if ( !isset($_REQUEST['currency']) || !$_REQUEST['currency'] )
            Zero_App::ResponseJson500(-1, ["параметр валюта не задан"]);
        else if ( !isset($_REQUEST['type']) || !$_REQUEST['type'] )
            Zero_App::ResponseJson500(-1, ["параметр тип не задан"]);

        $response = [];
        $sql = "SELECT * FROM Solution WHERE Typ = '{$_REQUEST['type']}' AND Location = '{$_REQUEST['country']}'";
        $rows = Zero_DB::Select_Array($sql);
        foreach ($rows as $row)
        {
            $response[] = [
                "id" => $row['ID'],
                "type" => $row['Groups'],
                "image" => $row['Image'],
                "title" => $row['Title'],
                "description" => $row['Description'],
                "subtitle" => $row['Subtitle'],
                "price" => 'eur' == $_REQUEST['currency'] ? $row['PriceEUR'] : $row['PriceRUR'],
            ];
        }
        Zero_App::ResponseJson200($response);
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Solution_Api_General
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
