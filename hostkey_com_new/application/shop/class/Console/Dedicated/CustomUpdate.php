<?php

/**
 * Кеширование конфигураций кастомизатора
 *
 * Запршивает конфигурацию у инвентори для каждого раздела у которого установлены группы.
 *
 * @package Shop.Console.Dedicated
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-09-24
 */
class Shop_Console_Dedicated_CustomUpdate extends Zero_Controller
{
    /**
     * Контроллер по умолчанию
     *
     * @return boolean flag статус выполнения
     */
    public function Action_Default()
    {
        $sectionRows = Zero_Section::Get_SectionComponentGroup();
        foreach($sectionRows as $row)
        {
            $data = Zero_App::RequestJson("GET", "https://ug.hostkey.ru/api/v1.0/inv/component/salenew?currency={$row['Currency']}&groups={$row['ComponentGroup']}");
            if ( false == $data['ErrorStatus'] )
            {
                $section = Zero_Section::Make($row['ID']);
                $data['Content']['Currency'] = $row['Currency'];
                $data['Content']['ComponentGroup'] = $row['ComponentGroup'];
                $section->Cache->Set('ComponentGroup', $data['Content']);
            }
        }
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Console_Dedicated_CustomUpdate
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
