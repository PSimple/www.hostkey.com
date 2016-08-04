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
class Shop_Console_Domains_ZonePeriod extends Zero_Controller
{
    /**
     * Контроллер по умолчанию
     *
     * @return boolean flag статус выполнения
     */
    public function Action_Default()
    {
        $trubleList = 'Внимание, следующие TLD есть в прайс-листе, но периоды регистрации не известны. Уточните у регистратора периоды и после проставьте корректным группы' . "<br>\n";
        $ip = new Shop_Helper_RealtimeRegister();
        foreach (Zero_DB::Select_Array("SELECT ID, `Name`, `Groups` FROM DomainsZone") as $row)
        {
            $id = $row['ID'];
            $zone = $row['Name'];
            $arr = $ip->GET('/v2/tlds/' . substr($zone, 1) . '/info');
            if ( isset($arr['metadata']) )
            {
                $RegisterPeriod = isset($arr['metadata']['createDomainPeriods']) ? "'" . implode(',', $arr['metadata']['createDomainPeriods']) . "'" : 'NULL';
                $TransferPeriod = isset($arr['metadata']['transferDomainPeriods']) ? "'" . implode(',', $arr['metadata']['transferDomainPeriods']) . "'" : 'NULL';
                $RenewPeriod = isset($arr['metadata']['renewDomainPeriods']) ? "'" . implode(',', $arr['metadata']['renewDomainPeriods']) . "'" : 'NULL';
                $RenewPeriodAuto = isset($arr['metadata']['autoRenewDomainPeriods']) ? "'" . implode(',', $arr['metadata']['autoRenewDomainPeriods']) . "'" : 'NULL';
                $sql = "
                UPDATE DomainsZone SET
                  RegisterPeriod = {$RegisterPeriod},
                  TransferPeriod = {$TransferPeriod},
                  RenewPeriod = {$RenewPeriod},
                  RenewPeriodAuto = {$RenewPeriodAuto}
                WHERE
                  ID = {$id}
                ";
                Zero_DB::Update($sql);
            }
            else
            {
                $trubleList .= $row['Name'] . ': ' . $row['Groups'] . "<br>\n";
                Zero_DB::Update("UPDATE DomainsZone SET `Groups` = 'Trouble' WHERE ID = {$id}");
            }
            sleep(1);
        }

        // письмо
        $content = [
            'Reply' => ['Name' => 'hostkey.com', 'Email' => 'no-reply@hostkey.ru'],
            'From' => ['Name' => 'hostkey.com', 'Email' => 'no-reply@hostkey.ru'],
            'To' => [
                ['Name' => 'kshamiev', 'Email' => 'kshamiev@hostkey.ru'],
                ['Name' => 'domains', 'Email' => 'domains@hostkey.com'],
            ],
            'Subject' => 'Ошибки обновления периодов зон',
            'Message' => $trubleList,
        ];
        $cnt = Zero_Helper_Mail::SendMessageAuthSsl($content);
        if ( 0 < $cnt )
        {
            Zero_Logs::Set_Message_Error("ошибка отправки письма: " . __FILE__ . ' (' . __LINE__ . ')');
        }

        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Console_Domains_ZonePeriod
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
