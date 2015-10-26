<?php

/**
 * Получение кеширонной конфигурации для кастомизатора указанного раздела
 *
 * Загружает ранее закешированную конфигурцию
 *
 * @package Shop.ConfigCalculator.Api
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-09-24
 */
class Shop_ConfigCalculator_Api_GetConfig extends Zero_Controller
{
    /**
     * Получение кеширонной конфигурации для кастомизатора указанного раздела
     *
     * @sample /api/v1/configcalculator/getconfig ?currency=eur&groups=NL,Mini
     *
     * @return boolean flag статус выполнения
     */
    public function Action_GET()
    {
        if ( !isset($_REQUEST['currency']) || !$_REQUEST['groups'])
            Zero_App::ResponseJson200();

        $obj = Shop_ConfigCalculator::Make();
        $data['Content']['Currency'] = $_REQUEST['currency'];
        $data['Content']['ComponentGroup'] = $_REQUEST['groups'];
        $response = $obj->Cache->Get_Data('ConfigCalculator/' . md5($_REQUEST['currency'] . $_REQUEST['groups']));
        Zero_App::ResponseJson200($response);
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_ConfigCalculator_Api_GetConfig
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
