<?php

/**
 * Сохранение конфигурации сервера в биллинге.
 *
 * Для дальнейшего оформления заказа на него.
 *
 * @package Shop.Dedicated.Api
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-11-28
 */
class Shop_Dedicated_Api_Order extends Zero_Controller
{
    /**
     * Формирование заказа.
     *
     * Если "Calculation" == true производится только расчет стоимости заказа и скидка
     *
     * @sample /api/v1/dedicated/order
     *
     * @return boolean flag статус выполнения
     */
    public function Action_POST()
    {
        if ( !isset($_REQUEST['Currency']) || !$_REQUEST['Groups'] )
            Zero_App::ResponseJson200(null, -1, ["параметры групп или валюта не заданы"]);

        // Получение конфигурации
        $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorDedicated/' . md5($_REQUEST['Currency'] . $_REQUEST['Groups']) . '.data';
        if ( !file_exists($path) )
            Zero_App::ResponseJson200(null, -1, ["файл конфигурации не найден"]);

        $response = unserialize(file_get_contents($path));

        // Расчет
        $Calculate = $response['Data'];
        // Hardvare
        $costHardvare = 0;
        $costHardvare += $Calculate[1][$_REQUEST['Hardware']['Cpu']]['Price'];
        $costHardvare += $Calculate[3][$_REQUEST['Hardware']['Ram']]['Price'];
        $costHardvare += $Calculate[6][$_REQUEST['Hardware']['Platform']]['Price'];
        foreach ($_REQUEST['Hardware']['Hdd'] as $id)
        {
            if ( $id > 0 )
                $costHardvare += $Calculate[2][$id]['Price'];
        }
        $costHardvare += $Calculate[8][$_REQUEST['Hardware']['Raid']]['Price'];

        $sum = $costHardvare;

        if ( $_REQUEST['Calculation'] )
        {
            Zero_App::ResponseJson200([
                "Summa" => $sum,
                "Discount" => $sum / 2,
            ]);
            return true;
        }

        // Формирование заказа
        Zero_App::ResponseJson200([
            "Summa" => $sum,
            "Discount" => $sum / 2,
            "OptionID" => 543,
            "Configuration" => "bla bla bla",
        ]);
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Dedicated_Api_Order
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
