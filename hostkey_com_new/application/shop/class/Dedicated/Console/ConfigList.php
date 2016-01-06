<?php

/**
 * Кеширование списка компоннетов по типам
 *
 * Запршивает конфигурацию у инвентори.
 *
 * @package Shop.Dedicated.Console
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.12.28
 */
class Shop_Dedicated_Console_ConfigList extends Zero_Controller
{
    /**
     * Кеширование списка компоннетов по типам
     *
     * @return boolean flag статус выполнения
     */
    public function Action_Default()
    {
        $config = Zero_Config::Get_Config('shop', 'config');
        // OS
        $url = "https://ug.hostkey.ru/api/v1.0/inv/component/list?typ=4&currency={$config['currency']}";
        $data = Zero_App::RequestJson("GET", $url);
        if ( false == $data['ErrorStatus'] )
        {
            $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorList/' . md5($config['currency']) . '4.data';
            Zero_Helper_File::File_Save($path, serialize($data['Content']));
        }
        // Port
        $url = "https://ug.hostkey.ru/api/v1.0/inv/component/list?typ=13&currency={$config['currency']}";
        $data = Zero_App::RequestJson("GET", $url);
        if ( false == $data['ErrorStatus'] )
        {
            $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorList/' . md5($config['currency']) . '13.data';
            Zero_Helper_File::File_Save($path, serialize($data['Content']));
        }
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Dedicated_Console_ConfigList
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