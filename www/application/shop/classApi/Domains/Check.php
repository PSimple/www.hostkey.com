<?php

/**
 * Проверка домена
 *
 * @package Shop.Api.Domains
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016.05.26
 */
class Shop_Api_Domains_Check extends Zero_Controller
{
    /**
     * Получение списка зон доменов по группам
     *
     * @return boolean flag статус выполнения
     */
    public function Action_GET()
    {
        // Проверки
        if ( !isset($_REQUEST['domainList']) || !$_REQUEST['domainList'] )
            Zero_App::ResponseJson500(-1, ["параметр доменов не задан"]);

        $sql = "
        SELECT
          `Name`
        FROM DomainsZone
        WHERE
          `Groups` LIKE '%Top20%'
        ";
        $zoneListTop = Zero_DB::Select_List($sql);
        $sql = "
        SELECT
          `Name`
        FROM DomainsZone
        WHERE
          `Groups` LIKE '%Promo%'
        ";
        $zoneListPromo = Zero_DB::Select_List($sql);

        $obj = new Shop_Helper_RealtimeRegister;

        $result = [];
        $arr = explode(",", $_REQUEST['domainList']);
        foreach ($arr as $d)
        {
            if ( false !== strpos($d, '.') )
            {
                $data = $obj->GET("/v2/domains/{$d}/check");
                if ( isset($data['available']) )
                    $result[$d] = $data['available'];
                else
                    $result[$d] = 'error';
            }
            else
            {
                foreach ($zoneListTop as $z)
                {
                    $dd = $d . $z;
                    $data = $obj->GET("/v2/domains/{$dd}/check");
                    if ( isset($data['available']) )
                        $result[$dd] = $data['available'];
                    else
                        $result[$dd] = 'error';
                }
                foreach ($zoneListPromo as $z)
                {
                    $dd = $d . $z;
                    $data = $obj->GET("/v2/domains/{$dd}/check");
                    if ( isset($data['available']) )
                        $result[$dd] = $data['available'];
                    else
                        $result[$dd] = 'error';
                }
            }
        }
        Zero_App::ResponseJson200($result);
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Api_Domains_Check
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
