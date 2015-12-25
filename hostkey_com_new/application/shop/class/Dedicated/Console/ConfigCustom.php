<?php

/**
 * Кеширование конфигураций компонентов по группам для формирования серверов dedicated
 *
 * Запршивает конфигурацию у инвентори.
 *
 * @package Shop.Dedicated.Console
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-09-24
 */
class Shop_Dedicated_Console_ConfigCustom extends Zero_Controller
{
    /**
     * Контроллер по умолчанию
     *
     * @return boolean flag статус выполнения
     */
    public function Action_Default()
    {
        $config = Zero_Config::Get_Config('shop', 'config');
        $sectionRows = Shop_ConfigCalculator::Get_ConfigCalculatorAll();
        foreach($sectionRows as $row)
        {
            $url = "https://ug.hostkey.ru/api/v1.0/inv/component/salenew?currency={$config['currency']}&groups={$row['ComponentGroup']}";
            $data = Zero_App::RequestJson("GET", $url);
            if ( false == $data['ErrorStatus'] )
            {

                $data['Content']['Currency'] = $config['currency'];
                $data['Content']['ComponentGroup'] = $row['ComponentGroup'];
                $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorDedicated/' . md5($config['currency'] . $row['ComponentGroup']) . '.data';
                Zero_Helper_File::File_Save($path, serialize($data['Content']));
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
