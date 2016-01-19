<?php

/**
 * Кеширование стока для доформирования серверов dedicated
 *
 * Запршивает конфигурацию у инвентори.
 *
 * @package Shop.Dedicated.Console
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.09.24
 */
class Shop_Dedicated_Console_ConfigStock extends Zero_Controller
{
    /**
     * Контроллер по умолчанию
     *
     * @return boolean flag статус выполнения
     */
    public function Action_Default()
    {
        $config = Zero_Config::Get_Config('shop', 'config');
        $sectionRows = Shop_ConfigSolution::Get_ConfigGroupsAll();
        foreach($sectionRows as $gr)
        {
            $url = "https://ug.hostkey.ru/api/v1.0/inv/component1/stock?currency={$config['currency']}&groups={$gr}";
            $data = Zero_App::RequestJson("GET", $url);
            if ( false == $data['ErrorStatus'] )
            {
                $data = [
                    'Data' => $data['Content'],
                    'Currency' => $config['currency'],
                    'ComponentGroup' => $gr,
                ];
                $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorDedicatedStock/' . md5($config['currency'] . $gr) . '.data';
                Zero_Helper_File::File_Save($path, serialize($data));
            }
        }
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Dedicated_Console_ConfigStock
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
