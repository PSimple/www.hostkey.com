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

        // Домены
        $domainList = explode(",", $_REQUEST['domainList']);
        // Зоны указанные
        $zoneListTarget = isset($_REQUEST['zoneList']) ? explode(',', $_REQUEST['zoneList']) : [];
        // Зоны Top20
        $sql = "
        SELECT
          `Name`
        FROM DomainsZone
        WHERE
          `Groups` LIKE '%Top20%'
        ";
        $zoneListTop20 = Zero_DB::Select_List($sql);
        // Зоны Promo
        $sql = "
        SELECT
          `Name`
        FROM DomainsZone
        WHERE
          `Groups` LIKE '%Promo%'
        ";
        $zoneListPromo = Zero_DB::Select_List($sql);
        // Общее количество общих запросов
        $cntRequestAll = (count($zoneListTarget) + count($zoneListTop20) + count($zoneListPromo)) * count($domainList);

        // Поиск
        $ip = new Shop_Helper_RealtimeRegisterTelnet('hostkey-ote/admin', '50ftWoman');
        foreach ($domainList as $d)
        {
            // zone Personal
            $arr = explode('.', $d);
            if ( 1 < count($arr) )
            {
                $d = $arr[0];
                $ip->Check($d, [$arr[1]]);
                $cntRequestAll++;
            }
            // zone Target
            $ip->Check($d, $zoneListTarget);
            // zone Top20
            $ip->Check($d, $zoneListTop20);
            // zone Promo
            $ip->Check($d, $zoneListPromo);
        }

        // Result
        $response = [];
        $cntFlag = 0;
        while ( $result = $ip->Result() )
        {
            $cntFlag++;
            $response[$result['domain']]['status'] = $result['result'];
            $response[$result['domain']]['priceRegistration'] = 2.5;
            $response[$result['domain']]['priceDelivery'] = 2.5;
            $response[$result['domain']]['priceOld'] = 2.5;
            if ( $cntFlag == $cntRequestAll )
            {
                $ip->Logout();
                break;
            }
        }
        ksort($response);

        Zero_App::ResponseJson200($response);
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
