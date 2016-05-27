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
            $sql = "SELECT COUNT(*) FROM DomainsZone WHERE `Name` = '{$row['extension']}'";
            if ( 0 < Zero_DB::Select_Field($sql) )
            {
                $sql = "
                UPDATE DomainsZone SET
                  PriceRegister = {$row['domainregister_msetupfee']},
                  `Order` = {$row['order']},
                  IsExist = 1
                WHERE
                  `Name` = '{$row['extension']}'
                ";
                Zero_DB::Update($sql);
            }
            else
            {
                $sql = "INSERT INTO DomainsZone SET
                  `Name` = '{$row['extension']}',
                  `Order` = {$row['order']},
                  `PriceRegister` = {$row['domainregister_msetupfee']},
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
