<?php

/**
 * Сохранение конфигурации сервера в биллинге.
 *
 * Для дальнейшего оформления заказа на него.
 *
 * @package Shop.Api.Dedicated
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-09-25
 */
class Shop_Api_Dedicated_CustomOrder extends Zero_Controller
{
    /**
     * Получение кеширонной конфигурации для кастомизатора указанного раздела
     *
     * @sample /api/v1/dedicated/config?id=54
     *
     * @return boolean flag статус выполнения
     */
    public function Action_GET()
    {
        if ( isset($_REQUEST['sample']) )
        {
            $sample = [
                'Hardware' => [
                    'Cpu' => 345,
                    'Ram' => 345,
                    'Platform' => 345,
                    'Hdd' => [
                        345,
                        345,
                        345,
                        345,
                    ],
                    'Raid' => 345,
                    'RaidLevel' => 5,
                ],
                'Software' => [
                    'OS' => 345,
                    'Bit' => 345,
                    'RdpLicCount' => 2,
                    'Sql' => 345,
                    'Exchange' => 345,
                    'ExchangeCount' => 3,
                    'CP' => 345,
                ],
                'Network' => [
                    'Traffic' => 345,
                    'Bandwidth' => 345,
                    'IP' => 345,
                    'Vlan' => 345,
                    'FtpBackup' => 345,
                ],
                'SLA' => [
                    'ServiceLevel' => 345,
                    'Management' => 345,
                    'Comment' => 'bla bla bla',
                    'CycleDiscount' => 'monthly',
                ],
            ];
            Zero_App::ResponseJson($sample, 200);
        }
        Zero_App::ResponseJson(null, 200);
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Api_Dedicated_CustomOrder
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
