<?php

/**
 * Проверка нескольких доменов по указзанной группе зон
 *
 * @package Shop.Api.Domains
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016.05.26
 */
class Shop_Api_Domains_CheckGroups extends Zero_Controller
{
    /**
     * Проверка нескольких доменов по указзанной группе зон
     *
     * @return boolean flag статус выполнения
     */
    public function Action_GET()
    {
        // Проверки
        if ( !isset($_REQUEST['domainList']) || !$_REQUEST['domainList'] )
            Zero_App::ResponseJson500(-1, ["параметр доменов не задан"]);
        if ( !isset($_REQUEST['group']) || !$_REQUEST['group'] )
            Zero_App::ResponseJson500(-1, ["группа не задана"]);
        if ( !isset($_REQUEST['pg']) || !$_REQUEST['pg'] )
            $sql_limit = '';
        else
            $sql_limit = 'LIMIT ' . (( $_REQUEST['pg'] - 1) * 20) . ', 20';


        // Домены
        $domainList = explode(",", $_REQUEST['domainList']);

        // Зоны группы
        $sqlGroup = Zero_DB::EscT('%' . $_REQUEST['group'] . '%');
        $sql = "
        SELECT
          `Name`
        FROM DomainsZone
        WHERE
          `Groups` LIKE {$sqlGroup}
        ORDER BY
          Sort ASC
        {$sql_limit}
        ";
        $zoneList = Zero_DB::Select_List($sql);

        // Общее количество общих запросов
        $cntRequestAll = count($zoneList) * count($domainList);

        // Цена зон
        $sql = "SELECT `Name`, PriceRegister, PriceTransfer, PriceRenew, PriceOld FROM DomainsZone WHERE `Groups` LIKE {$sqlGroup}";
        $zoneListPrice = Zero_DB::Select_Array_Index($sql);

        // Поиск
        Zero_Logs::Start('realtimeregister');
        $ip = new Shop_Helper_RealtimeRegisterTelnet('hostkey-ote/admin', '50ftWoman');
        foreach ($domainList as $d)
        {
            $ip->Check($d, $zoneList);
        }
        // Result
        $response = [];
        $cntFlag = 0;
        while ( $result = $ip->Result() )
        {
            $arr = explode('.', $result['domain']);
            $zone = '.' . array_pop($arr);

            $cntFlag++;
            $response[$result['domain']]['status'] = $result['result'];
            $response[$result['domain']]['priceRegister'] = isset($zoneListPrice[$zone]) ? $zoneListPrice[$zone]['PriceRegister'] : 0.00;
            $response[$result['domain']]['priceTransfer'] = isset($zoneListPrice[$zone]) ? $zoneListPrice[$zone]['PriceTransfer'] : 0.00;
            $response[$result['domain']]['priceRenew'] = isset($zoneListPrice[$zone]) ? $zoneListPrice[$zone]['PriceRenew'] : 0.00;
            $response[$result['domain']]['priceOld'] = isset($zoneListPrice[$zone]) ? $zoneListPrice[$zone]['PriceOld'] : 0.00;
            //
            if ( $cntFlag == $cntRequestAll )
            {
                $ip->Logout();
                break;
            }
        }
        Zero_Logs::Stop('realtimeregister');
        ksort($response);

        Zero_App::ResponseJson200($response);
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Api_Domains_CheckGroups
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
