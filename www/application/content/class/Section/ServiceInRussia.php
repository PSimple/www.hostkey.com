<?php

/**
 * Контент страницы (раздела).
 *
 * @package Content.Section.Controller
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.07.17
 */
class Content_Section_ServiceInRussia extends Zero_Controller
{
    /**
     * Контроллер по умолчанию.
     *
     * @return string
     */
    public function Action_Default()
    {
        $this->Chunk_Init();

        $head = str_replace(' ', '<br>', Zero_App::$Section->Name);
        $this->View->Assign('head', $head);
        $this->View->Assign('content', Zero_App::$Section->Content);

        $this->Chunk_View();
        return $this->View;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Content_Section_ServiceInRussia
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
