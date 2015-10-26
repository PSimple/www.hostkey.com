<?php

/**
 * Кеширование конфигураций кастомизатора
 *
 * Запршивает конфигурацию у инвентори для каждого раздела у которого установлены группы.
 *
 * @package Shop.ConfigCalculator.Console
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-09-24
 */
class Shop_ConfigCalculator_Console_Update extends Zero_Controller
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
            $data = Zero_App::RequestJson("GET", "https://ug.hostkey.ru/api/v1.0/inv/component/salenew?currency={$row['Currency']}&groups={$row['ComponentGroup']}");
            if ( false == $data['ErrorStatus'] )
            {
                $obj = Shop_ConfigCalculator::Make();
                $data['Content']['Currency'] = $row['Currency'];
                $data['Content']['ComponentGroup'] = $row['ComponentGroup'];
                $obj->Cache->Set_Data('ConfigCalculator/' . md5($row['Currency'] . $row['ComponentGroup']), $data['Content']);
            }
        }
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_ConfigCalculator_Console_Update
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
