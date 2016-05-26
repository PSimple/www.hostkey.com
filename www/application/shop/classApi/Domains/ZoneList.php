<?php

/**
 * Получение списка зон доменов по группам
 *
 * @package Shop.Api.Domains
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016.05.26
 */
class Shop_Api_Domains_ZoneList extends Zero_Controller
{
    /**
     * Получение списка зон доменов по группам
     *
     * @return boolean flag статус выполнения
     */
    public function Action_GET()
    {
        // Проверки
        if ( !isset($_REQUEST['groups']) || !$_REQUEST['groups'] )
            Zero_App::ResponseJson500(-1, ["параметр групп не задан"]);

        // Получаем список
        $sql = "
        SELECT
          *
        FROM DomainsZone
        WHERE
          `Groups` = '{$_REQUEST['groups']}'
        ";
        $result = Zero_DB::Select_Array($sql);
        Zero_App::ResponseJson200($result);
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Api_Domains_ZoneList
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
