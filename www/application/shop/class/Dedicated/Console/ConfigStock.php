<?php

/**
 * Кеширование стока для доформирования серверов dedicated
 *
 * Запршивает конфигурацию у инвентори.
 *
 * @package Shop.Dedicated.Console
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016-02-04
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
        //        $sectionRows = Shop_Solution::Get_ConfigGroupsAll();
        //        foreach($sectionRows as $gr)
        //        {
        //            $url = "https://ug.hostkey.ru/api/v1.0/inv/component1/stock?currency={$config['currency']}&groups={$gr}";
        //            $data = Zero_App::RequestJson("GET", $url);
        //            if ( false == $data['ErrorStatus'] )
        //            {
        //                $data = [
        //                    'Data' => $data['Content'],
        //                    'Currency' => $config['currency'],
        //                    'ComponentGroup' => $gr,
        //                ];
        //                $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorDedicatedStock/' . md5($config['currency'] . $gr) . '.data';
        //                Zero_Helper_File::File_Save($path, serialize($data));
        //            }
        //        }
        // NL
        $url = Shop_Config_General::URL_API_INVENTORY . "/api/v1.0/inv/component1/stock?groups=NL";
        $data = Zero_App::RequestJson("GET", $url);
        if ( false == $data['ErrorStatus'] && isset($data['Content']) )
        {
            $data = [
                'Data' => $data['Content'],
                'ComponentGroup' => 'NL',
            ];
            $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorDedicatedStock/NL.data';
            Zero_Helper_File::File_Save($path, serialize($data));
        }
        // RU
        $url = Shop_Config_General::URL_API_INVENTORY . "/api/v1.0/inv/component1/stock?groups=RU";
        $data = Zero_App::RequestJson("GET", $url);
        if ( false == $data['ErrorStatus'] && isset($data['Content']) )
        {
            $data = [
                'Data' => $data['Content'],
                'ComponentGroup' => 'RU',
            ];
            $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorDedicatedStock/RU.data';
            Zero_Helper_File::File_Save($path, serialize($data));
        }
        // ALL
        $url = Shop_Config_General::URL_API_INVENTORY . "/api/v1.0/inv/component1/stock";
        $data = Zero_App::RequestJson("GET", $url);
        if ( false == $data['ErrorStatus'] && isset($data['Content']) )
        {
            $data = [
                'Data' => $data['Content'],
                'ComponentGroup' => 'All',
            ];
            $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorDedicatedStock/All.data';
            Zero_Helper_File::File_Save($path, serialize($data));
        }
        //
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
