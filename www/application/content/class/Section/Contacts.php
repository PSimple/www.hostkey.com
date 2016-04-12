<?php

/**
 * Контент страницы.
 *
 * Контакты
 *
 * @package Content.Controller.Section
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.07.20
 */
class Content_Section_Contacts extends Zero_Controller
{
    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Content_Section_Contacts
     */
    public static function Make($properties = [])
    {
        $Controller = new self();
        foreach ($properties as $property => $value) {
            $Controller->Params[$property] = $value;
        }
        return $Controller;
    }
}
