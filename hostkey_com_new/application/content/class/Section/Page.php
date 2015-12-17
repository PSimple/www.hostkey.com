<?php

/**
 * Контент страницы (раздела).
 *
 * @package Content.Section.Controller
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.07.17
 */
class Content_Section_Page extends Zero_Controller
{
    /**
     * Контроллер по умолчанию.
     *
     * @return string
     */
    public function Action_Default()
    {
        $this->Chunk_Init();
       pre( Zero_App::$Section->ID );
        $head = str_replace(' ', '<br>', Zero_App::$Section->Name);
        $this->View->Assign('head', $head);
        $this->View->Assign('content', Zero_App::$Section->Content );

        return $this->View;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Content_Section_Page
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
