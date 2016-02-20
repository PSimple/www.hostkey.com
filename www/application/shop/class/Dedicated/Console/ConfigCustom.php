<?php

/**
 * Кеширование конфигураций компонентов по группам для формирования серверов dedicated
 *
 * Запршивает конфигурацию у инвентори.
 *
 * @package Shop.Dedicated.Console
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016-02-04
 */
class Shop_Dedicated_Console_ConfigCustom extends Zero_Controller
{
    /**
     * Кеширование конфигураций компонентов по группам для формирования серверов dedicated
     *
     * @return boolean flag статус выполнения
     */
    public function Action_Default()
    {
        $sectionRows = Shop_Solution::Get_ConfigGroupsAll();
        foreach ($sectionRows as $gr)
        {
            $url = Shop_Config_General::URL_API_INVENTORY . "/api/v1.0/inv/component/salenew?groups={$gr}";
            $data = Zero_App::RequestJson("GET", $url);
            if ( false == $data['ErrorStatus'] && isset($data['Content']) )
            {
                $data['Content']['ComponentGroup'] = $gr;
                $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorDedicated/' . str_replace(',', '_', $gr) . '.data';
                Zero_Helper_File::File_Save($path, serialize($data['Content']));
            }
        }
        // NL старое не используется
        $url = Shop_Config_General::URL_API_INVENTORY . "/api/v1.0/inv/component/salenew?groups=NL";
        $data = Zero_App::RequestJson("GET", $url);
        if ( false == $data['ErrorStatus'] && isset($data['Content']) )
        {
            $data['Content']['ComponentGroup'] = 'NL';
            $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorDedicated/NL.data';
            Zero_Helper_File::File_Save($path, serialize($data['Content']));
        }
        // RU старое не используется
        $url = Shop_Config_General::URL_API_INVENTORY . "/api/v1.0/inv/component/salenew?groups=RU";
        $data = Zero_App::RequestJson("GET", $url);
        if ( false == $data['ErrorStatus'] && isset($data['Content']) )
        {
            $data['Content']['ComponentGroup'] = 'RU';
            $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorDedicated/RU.data';
            Zero_Helper_File::File_Save($path, serialize($data['Content']));
        }
        // обновляем нестандартные группы
        foreach (glob(ZERO_PATH_EXCHANGE . '/ConfigCalculatorDedicated/*.data') as $filePath)
        {
            if ( 240 < (time() - filemtime($filePath)) )
            {
                $arr = explode('/', $filePath);
                $arr = explode('.', array_pop($arr));
                $arr = explode('_', $arr[0]);
                Zero_Logs::Set_Message_Notice($arr);

                $url = Shop_Config_General::URL_API_INVENTORY . "/api/v1.0/inv/component/salenew?groups=" . implode(',', $arr);
                $data = Zero_App::RequestJson("GET", $url);
                if ( false == $data['ErrorStatus'] && isset($data['Content']) )
                {
                    $data['Content']['ComponentGroup'] = implode(',', $arr);
                    Zero_Helper_File::File_Save($filePath, serialize($data['Content']));
                }
            }
        }
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Dedicated_Console_ConfigCustom
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
