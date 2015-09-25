<?php

/**
 * Получение кеширонной конфигурации для кастомизатора указанного раздела
 *
 * Загружает ранее закешированную конфигурцию
 *
 * @package Shop.Api.Dedicated
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-09-24
 */
class Shop_Api_Dedicated_CustomConfig extends Zero_Controller
{
    /**
     * Получение кеширонной конфигурации для кастомизатора указанного раздела
     *
     * @sample /api/v1/dedicated/config?id=54
     *
     * @return boolean flag статус выполнения
     */
    public function Action_GET()
    {
        if ( !isset($_REQUEST['id']) || !$_REQUEST['id'])
            Zero_App::ResponseJson(null, 500);

        $section = Zero_Section::Make($_REQUEST['id']);
        $data = $section->Cache->Get('ComponentGroup');
        Zero_App::ResponseJson($data, 200);
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Api_Dedicated_CustomConfig
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
