<?php

/**
 * Обновление доменных зон
 *
 * Запршивает конфигурацию у биллинга.
 *
 * @package Shop.Console.Domains
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016.05.26
 */
class Shop_Console_Domains_ZoneList extends Zero_Controller
{
    /**
     * Контроллер по умолчанию
     *
     * @return boolean flag статус выполнения
     */
    public function Action_Default()
    {
        $http = "https://bill.hostkey.com/api/v1/billing/domains/zone/list";
        $data = Zero_App::RequestJson("GET", $http);
        if ( true == $data['ErrorStatus'] || !isset($data['Content']) )
        {
            Zero_Logs::Set_Message_Error('Ошибка получение информации о зонах');
            return false;
        }
        Zero_DB::Update("UPDATE DomainsZone SET IsExist = 0");
        foreach ($data['Content'] as $row)
        {
            $Dnsmanagement = 'on' == $row['dnsmanagement'] ? 1 : 0;
            $Idprotection = 'on' == $row['idprotection'] ? 1 : 0;

            // заплатка для цен (поскольку при импорте зон в биллинге есть отсутсвующие цены)
            foreach ($row as $k => $v)
            {
                if ( is_null($v) )
                    $row[$k] = 0;
            }

            $sql = "SELECT COUNT(*) FROM DomainsZone WHERE `Name` = '{$row['extension']}'";
            if ( 0 < Zero_DB::Select_Field($sql) )
            {
                $sql = "
                UPDATE DomainsZone SET
                  Dnsmanagement = {$Dnsmanagement},
                  Idprotection = {$Idprotection},
                  PriceRegister = {$row['domainregister_msetupfee']},
                  PriceTransfer = {$row['domaintransfer_msetupfee']},
                  PriceRenew = {$row['domainrenew_msetupfee']},
                  `Order` = {$row['order']},
                  `PriceRegister01` = '{$row['domainregister_msetupfee']}',
                  `PriceRegister02` = '{$row['domainregister_qsetupfee']}',
                  `PriceRegister03` = '{$row['domainregister_ssetupfee']}',
                  `PriceRegister04` = '{$row['domainregister_asetupfee']}',
                  `PriceRegister05` = '{$row['domainregister_bsetupfee']}',
                  `PriceRegister06` = '{$row['domainregister_monthly']}',
                  `PriceRegister07` = '{$row['domainregister_quarterly']}',
                  `PriceRegister08` = '{$row['domainregister_semiannually']}',
                  `PriceRegister09` = '{$row['domainregister_annually']}',
                  `PriceRegister10` = '{$row['domainregister_biennially']}',
                  `PriceTransfer01` = '{$row['domaintransfer_msetupfee']}',
                  `PriceTransfer02` = '{$row['domaintransfer_qsetupfee']}',
                  `PriceTransfer03` = '{$row['domaintransfer_ssetupfee']}',
                  `PriceTransfer04` = '{$row['domaintransfer_asetupfee']}',
                  `PriceTransfer05` = '{$row['domaintransfer_bsetupfee']}',
                  `PriceTransfer06` = '{$row['domaintransfer_monthly']}',
                  `PriceTransfer07` = '{$row['domaintransfer_quarterly']}',
                  `PriceTransfer08` = '{$row['domaintransfer_semiannually']}',
                  `PriceTransfer09` = '{$row['domaintransfer_annually']}',
                  `PriceTransfer10` = '{$row['domaintransfer_biennially']}',
                  `PriceRenew01` = '{$row['domainrenew_msetupfee']}',
                  `PriceRenew02` = '{$row['domainrenew_qsetupfee']}',
                  `PriceRenew03` = '{$row['domainrenew_ssetupfee']}',
                  `PriceRenew04` = '{$row['domainrenew_asetupfee']}',
                  `PriceRenew05` = '{$row['domainrenew_bsetupfee']}',
                  `PriceRenew06` = '{$row['domainrenew_monthly']}',
                  `PriceRenew07` = '{$row['domainrenew_quarterly']}',
                  `PriceRenew08` = '{$row['domainrenew_semiannually']}',
                  `PriceRenew09` = '{$row['domainrenew_annually']}',
                  `PriceRenew10` = '{$row['domainrenew_biennially']}',
                  IsExist = 1
                WHERE
                  `Name` = '{$row['extension']}'
                ";
                Zero_DB::Update($sql);
            }
            else
            {
                $sql = "INSERT INTO DomainsZone SET
                  Dnsmanagement = {$Dnsmanagement},
                  Idprotection = {$Idprotection},
                  PriceRegister = {$row['domainregister_msetupfee']},
                  PriceTransfer = {$row['domaintransfer_msetupfee']},
                  PriceRenew = {$row['domainrenew_msetupfee']},
                  `Name` = '{$row['extension']}',
                  `Order` = {$row['order']},
                  `PriceRegister01` = '{$row['domainregister_msetupfee']}',
                  `PriceRegister02` = '{$row['domainregister_qsetupfee']}',
                  `PriceRegister03` = '{$row['domainregister_ssetupfee']}',
                  `PriceRegister04` = '{$row['domainregister_asetupfee']}',
                  `PriceRegister05` = '{$row['domainregister_bsetupfee']}',
                  `PriceRegister06` = '{$row['domainregister_monthly']}',
                  `PriceRegister07` = '{$row['domainregister_quarterly']}',
                  `PriceRegister08` = '{$row['domainregister_semiannually']}',
                  `PriceRegister09` = '{$row['domainregister_annually']}',
                  `PriceRegister10` = '{$row['domainregister_biennially']}',
                  `PriceTransfer01` = '{$row['domaintransfer_msetupfee']}',
                  `PriceTransfer02` = '{$row['domaintransfer_qsetupfee']}',
                  `PriceTransfer03` = '{$row['domaintransfer_ssetupfee']}',
                  `PriceTransfer04` = '{$row['domaintransfer_asetupfee']}',
                  `PriceTransfer05` = '{$row['domaintransfer_bsetupfee']}',
                  `PriceTransfer06` = '{$row['domaintransfer_monthly']}',
                  `PriceTransfer07` = '{$row['domaintransfer_quarterly']}',
                  `PriceTransfer08` = '{$row['domaintransfer_semiannually']}',
                  `PriceTransfer09` = '{$row['domaintransfer_annually']}',
                  `PriceTransfer10` = '{$row['domaintransfer_biennially']}',
                  `PriceRenew01` = '{$row['domainrenew_msetupfee']}',
                  `PriceRenew02` = '{$row['domainrenew_qsetupfee']}',
                  `PriceRenew03` = '{$row['domainrenew_ssetupfee']}',
                  `PriceRenew04` = '{$row['domainrenew_asetupfee']}',
                  `PriceRenew05` = '{$row['domainrenew_bsetupfee']}',
                  `PriceRenew06` = '{$row['domainrenew_monthly']}',
                  `PriceRenew07` = '{$row['domainrenew_quarterly']}',
                  `PriceRenew08` = '{$row['domainrenew_semiannually']}',
                  `PriceRenew09` = '{$row['domainrenew_annually']}',
                  `PriceRenew10` = '{$row['domainrenew_biennially']}',
                  IsExist = 1
                ";
                Zero_DB::Insert($sql);
            }
        }
        Zero_DB::Update("DELETE FROM DomainsZone WHERE IsExist = 0");
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Console_Domains_ZoneList
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
