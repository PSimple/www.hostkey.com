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
            Zero_App::ResponseJson500(-1, ["домены не заданы"]);
        if ( !isset($_REQUEST['group']) || !$_REQUEST['group'] )
            Zero_App::ResponseJson500(-1, ["группа не задана"]);
        if ( !isset($_REQUEST['pg']) || !$_REQUEST['pg'] )
            $sql_limit = '';
        else
            $sql_limit = 'LIMIT ' . (($_REQUEST['pg'] - 1) * 20) . ', 20';

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
        if ( 0 == count($zoneList) )
            Zero_App::ResponseJson500(-1, ["не ни одной привязанной зоны"]);

        // Общее количество общих запросов
        $cntRequestAll = count($zoneList) * count($domainList);

        // Цена зон
        $sql = "
        SELECT `Name`, PriceOld, Idprotection, Img, `PriceRegister01`, Description,
          `PriceRegister02`, `PriceRegister03`, `PriceRegister04`, `PriceRegister05`, `PriceRegister06`,
          `PriceRegister07`, `PriceRegister08`, `PriceRegister09`, `PriceRegister10`, `PriceTransfer01`
          FROM DomainsZone
        ";
        $zoneListPrice = Zero_DB::Select_Array_Index($sql);

        // Поиск
        Zero_Logs::Start('realtimeregister');
        $ip = new Shop_Helper_RealtimeRegisterTelnet();
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
            $response[$result['domain']]['description'] = isset($zoneListPrice[$zone]) ? $zoneListPrice[$zone]['Description'] : '';
            $response[$result['domain']]['status'] = $result['result'];
            $response[$result['domain']]['idprotection'] = isset($zoneListPrice[$zone]) ? $zoneListPrice[$zone]['Idprotection'] : 0;
            $response[$result['domain']]['priceOld'] = isset($zoneListPrice[$zone]) ? $zoneListPrice[$zone]['PriceOld'] : 0.00;
            $response[$result['domain']]['img'] = isset($zoneListPrice[$zone]) ? $zoneListPrice[$zone]['Img'] : '';
            $response[$result['domain']]['PriceRegister01'] = isset($zoneListPrice[$zone]) ? $zoneListPrice[$zone]['PriceRegister01'] : 0.00;
            $response[$result['domain']]['PriceRegister02'] = isset($zoneListPrice[$zone]) ? $zoneListPrice[$zone]['PriceRegister02'] : 0.00;
            $response[$result['domain']]['PriceRegister03'] = isset($zoneListPrice[$zone]) ? $zoneListPrice[$zone]['PriceRegister03'] : 0.00;
            $response[$result['domain']]['PriceRegister04'] = isset($zoneListPrice[$zone]) ? $zoneListPrice[$zone]['PriceRegister04'] : 0.00;
            $response[$result['domain']]['PriceRegister05'] = isset($zoneListPrice[$zone]) ? $zoneListPrice[$zone]['PriceRegister05'] : 0.00;
            $response[$result['domain']]['PriceRegister06'] = isset($zoneListPrice[$zone]) ? $zoneListPrice[$zone]['PriceRegister06'] : 0.00;
            $response[$result['domain']]['PriceRegister07'] = isset($zoneListPrice[$zone]) ? $zoneListPrice[$zone]['PriceRegister07'] : 0.00;
            $response[$result['domain']]['PriceRegister08'] = isset($zoneListPrice[$zone]) ? $zoneListPrice[$zone]['PriceRegister08'] : 0.00;
            $response[$result['domain']]['PriceRegister09'] = isset($zoneListPrice[$zone]) ? $zoneListPrice[$zone]['PriceRegister09'] : 0.00;
            $response[$result['domain']]['PriceRegister10'] = isset($zoneListPrice[$zone]) ? $zoneListPrice[$zone]['PriceRegister10'] : 0.00;
            $response[$result['domain']]['PriceTransfer01'] = isset($zoneListPrice[$zone]) ? $zoneListPrice[$zone]['PriceTransfer01'] : 0.00;
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
