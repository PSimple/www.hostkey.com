<?php

/**
 * Кеширование конфигураций dedicated
 *
 * Запршивает конфигурацию у инвентори.
 *
 * @package Shop.Dedicated.Console
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-09-24
 */
class Shop_Dedicated_Console_Update extends Zero_Controller
{
    /**
     * Контроллер по умолчанию
     *
     * @return boolean flag статус выполнения
     */
    public function Action_Default()
    {
        $sectionRows = Shop_ConfigCalculator::Get_ConfigCalculatorAll();
        foreach($sectionRows as $row)
        {
            $row['Currency'] = 'eur';
            $data = Zero_App::RequestJson("GET", "https://ug.hostkey.ru/api/v1.0/inv/component/salenew?currency={$row['Currency']}&groups={$row['ComponentGroup']}");
            if ( false == $data['ErrorStatus'] )
            {

                $data['Content']['Currency'] = $row['Currency'];
                $data['Content']['ComponentGroup'] = $row['ComponentGroup'];
                $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorDedicated/' . md5($row['Currency'] . $row['ComponentGroup']) . '.data';
                Zero_Helper_File::File_Save($path, serialize($data['Content']));
            }
        }
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Dedicated_Console_Update
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
