<?php

/**
 * Сохранение конфигурации сервера в биллинге.
 *
 * Для дальнейшего оформления заказа на него.
 *
 * @package Shop.ConfigCalculator.Api
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-09-25
 */
class Shop_ConfigCalculator_Api_Order extends Zero_Controller
{
    /**
     * Получение кеширонной конфигурации для кастомизатора указанного раздела
     *
     * @sample /api/v1/configcalculator/order
     *
     * @return boolean flag статус выполнения
     */
    public function Action_GET()
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
        Zero_App::ResponseJson200($sample);
        return true;
    }

    /**
     * Получение кеширонной конфигурации для кастомизатора указанного раздела
     *
     * @sample /api/v1/configcalculator/order
     *
     * @return boolean flag статус выполнения
     */
    public function Action_POST()
    {
        Zero_App::ResponseJson200();
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_ConfigCalculator_Api_Order
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
