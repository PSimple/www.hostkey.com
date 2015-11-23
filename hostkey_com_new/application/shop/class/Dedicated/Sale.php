<?php

/**
 * Продажи стока
 *
 * @package Shop.Dedicated.Controller
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.11.20
 */
class Shop_Dedicated_Sale extends Zero_Controller
{
    /**
     * Контроллер по умолчанию.
     *
     * @return Zero_View
     */
    public function Action_Default()
    {
        $this->Chunk_Init();

        $head = str_replace(' ', '<br>', Zero_App::$Section->Name);
        $this->View->Assign('head', $head);

        return $this->View->Fetch(false);
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Dedicated_Sale
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
