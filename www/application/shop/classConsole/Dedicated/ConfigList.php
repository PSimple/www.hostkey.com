<?php

/**
 * Кеширование списка компоннетов по типам
 *
 * Запршивает конфигурацию у инвентори.
 *
 * @package Shop.Console.Dedicated
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.12.28
 */
class Shop_Console_Dedicated_ConfigList extends Zero_Controller
{
    /**
     * Кеширование списка компоннетов по типам
     *
     * @return boolean flag статус выполнения
     */
    public function Action_Default()
    {
        // OS
        $url = Shop_Config_General::URL_API_INVENTORY . "/api/v1.0/inv/component/list?typ=4";
        $data = Zero_App::RequestJson("GET", $url);
        if ( false == $data['ErrorStatus'] && isset($data['Content']) )
        {
            $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorList/4.data';
            Zero_Helper_File::File_Save($path, serialize($data['Content']));
        }
        // Port
        $url = Shop_Config_General::URL_API_INVENTORY . "/api/v1.0/inv/component/list?typ=13";
        $data = Zero_App::RequestJson("GET", $url);
        if ( false == $data['ErrorStatus'] && isset($data['Content']) )
        {
            $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorList/13.data';
            Zero_Helper_File::File_Save($path, serialize($data['Content']));
        }
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Console_Dedicated_ConfigList
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
