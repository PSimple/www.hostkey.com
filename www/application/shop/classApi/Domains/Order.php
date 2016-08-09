<?php

/**
 * Получение списка зон по указанной группе
 *
 * @package Shop.Api.Domains
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016.05.26
 */
class Shop_Api_Domains_Order extends Zero_Controller
{
    /**
     * Получение списка зон по указанной группе
     *
     * @return boolean flag статус выполнения
     */
    public function Action_POST()
    {
        // https://bill.hostkey.com/cart.php?a=add&currency=2&pid=564&billingcycle=monthly&configoption[858]=15006&customfield[348]=описание-заказа

        // Проверки
        if ( !isset($_REQUEST['domains']) )
            Zero_App::ResponseJson500(-1, ["список доменов не указан 'domains'"]);

        $orderList = [];
        foreach($_REQUEST['domains'] as $domain => $row)
        {
            $zone = explode('.', $domain)[1];
            $orderList[$zone][$domain] = [
                'periodReg' => $row['periodReg'] / 12,
                'dns' => $row['dns'],
            ];
        }

        $result = Zero_App::RequestJson('POST', 'https://bill.hostkey.com/api/v1/billing/domains/orders', ['orderList' => $orderList]);
        if ( $result['ErrorStatus'] == false )
        {
            Zero_App::ResponseJson200($result['Content']);
        }
        else
        {
            Zero_App::ResponseJson500($result['Code'], [$result['Message']]);
        }
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Api_Domains_Order
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
