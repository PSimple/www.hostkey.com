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
        if (empty($_REQUEST['domains']) || empty($_REQUEST['dns']))
            Zero_App::ResponseJson500(-1, ["список доменов не указан 'domains'"]);

        // проверка dns
        $checkNs = [];
        foreach ($_REQUEST['dns'] as $ns) {
            $arr = explode('.', $ns);
            array_shift($arr);
            $ns = implode('.', $arr);
            $checkNs[$ns] = 1;
        }
        if (1 < count($checkNs))
            Zero_App::ResponseJson500(-1, ["ns сервера указаны не верно"]);

        $orderList = [];
        foreach ($_REQUEST['domains'] as $domain => $row) {
            $zone = explode('.', $domain)[1];
            $orderList[$zone][$domain] = [
                'advanced' => $row['advanced'],
                'periodReg' => $row['periodReg'] / 12,
                'periodTrans' => $row['periodTrans'] / 12,
                'periodRenew' => $row['periodRenew'] / 12,
                'dns' => $row['dns'],
            ];
        }

        $result = Zero_App::RequestJson('POST', 'https://bill.hostkey.com/api/v1/billing/domains/orders', ['orderList' => $orderList, 'dns' => $_REQUEST['dns']]);
        if ($result['ErrorStatus'] == false) {
            Zero_App::ResponseJson200($result['Content']);
        } else {
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
        foreach ($properties as $property => $value) {
            $Controller->Params[$property] = $value;
        }
        return $Controller;
    }
}
