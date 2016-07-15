<?php

/**
 * Проверка нескольких доменов
 *
 * @package Shop.Api.Domains
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016.05.26
 */
class Shop_Api_Domains_Check extends Zero_Controller
{
    /**
     * Проверка нескольких доменов
     *
     * @return boolean flag статус выполнения
     */
    public function Action_GET()
    {
        // Проверки
        if ( !isset($_REQUEST['domainList']) || !$_REQUEST['domainList'] )
            Zero_App::ResponseJson500(-1, ["параметр доменов не задан"]);

        // Домены
        $domainList = explode(",", $_REQUEST['domainList']);

        // Зоны в доменах
        $zoneListDomain = [];
        // Зоны указанные
        $zoneListTarget = isset($_REQUEST['zoneList']) ? explode(',', $_REQUEST['zoneList']) : [];
        // Зоны Top20
        $zoneListTop20 = Zero_DB::Select_List("SELECT `Name` FROM DomainsZone WHERE `Groups` LIKE '%Top20%'");
        // Зоны Promo
        $zoneListPromo = Zero_DB::Select_List("SELECT `Name` FROM DomainsZone WHERE `Groups` LIKE '%Promo%'");

        // Общее количество общих запросов
        $cntRequestAll = (count($zoneListTarget) + count($zoneListTop20) + count($zoneListPromo)) * count($domainList);

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
            // zone Personal
            $arr = explode('.', $d);
            if ( 1 < count($arr) )
            {
                $zoneListDomain[$d] = $arr[1];
                $d = $arr[0];
                $ip->Check($d, [$arr[1]]);
                $cntRequestAll++;
            }
            // zone Target
            if ( 0 < count($zoneListTarget) )
                $ip->Check($d, $zoneListTarget);
            // zone Top20
            if ( 0 < count($zoneListTop20) )
                $ip->Check($d, $zoneListTop20);
            // zone Promo
            if ( 0 < count($zoneListPromo) )
                $ip->Check($d, $zoneListPromo);
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
            // помечаем промо
            if ( in_array($zone, $zoneListPromo) )
                $response[$result['domain']]['promo'] = 1;
            //
            if ( $cntFlag == $cntRequestAll )
            {
                $ip->Logout();
                break;
            }
        }
        Zero_Logs::Stop('realtimeregister');
        ksort($response);

        // Подготовка к выводу. Разбиваем на группы
        $responseGroup1 = [];
        $responseGroup2 = [];
        foreach ($response as $d => $row)
        {
            $arr = explode('.', $d);
            if ( count($arr) != 2 )
            {
                Zero_Logs::Set_Message_Error('Домен в результате не корректный' . $d);
                continue;
            }
            if ( in_array($arr[1], $zoneListTarget) || isset($zoneListDomain[$d]) )
                $responseGroup1[$d] = $row;
            else if ( in_array('.' . $arr[1], $zoneListTop20) )
                $responseGroup2[$d] = $row;
            else if ( in_array('.' . $arr[1], $zoneListPromo) )
                $responseGroup2[$d] = $row;
            else
                Zero_Logs::Set_Message_Error('Домен не входит в одну зону' . $d);
        }

        Zero_App::ResponseJson200(['group1' => $responseGroup1, 'group2' => $responseGroup2]);
        return true;
        /*
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
        */
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
