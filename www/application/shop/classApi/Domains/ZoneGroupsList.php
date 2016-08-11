<?php

/**
 * Получение списка зон по указанной группе
 *
 * @package Shop.Api.Domains
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016.05.26
 */
class Shop_Api_Domains_ZoneGroupsList extends Zero_Controller
{
    /**
     * Получение списка зон по указанной группе
     *
     * @return boolean flag статус выполнения
     */
    public function Action_GET()
    {
        // Проверки
        if ( !isset($_REQUEST['groups']) || !$_REQUEST['groups'] )
            Zero_App::ResponseJson500(-1, ["параметр групп не задан"]);

        $sql_where = [];
        foreach (explode(',', $_REQUEST['groups']) as $group)
        {
            $sql_where[] = "`Groups` LIKE '%{$group}%'";
        }
        $sql_where = implode(' OR ', $sql_where);

        // Получаем список
        $sql = "
        SELECT
          *
        FROM DomainsZone
        WHERE
          {$sql_where}
        ORDER BY
          Sort ASC
        ";
        $result = Zero_DB::Select_Array($sql);
        foreach ($result as $k => $v)
        {
            unset($result[$k]['PriceRegister']);
            unset($result[$k]['PriceTransfer']);
            unset($result[$k]['PriceRenew']);
        }
        Zero_App::ResponseJson200($result);
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
