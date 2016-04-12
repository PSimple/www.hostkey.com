<?php

/**
 * Контент страницы (раздела).
 *
 * @package Content.Controller.Section
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
        preg_match_all('#(<.+?>)(.+?)(<\/.+?>)#is', Zero_App::$Section->Name, $match);
        if ( isset($match[2][0]) )
        {
            $head = str_replace(' ', '<br>', $match[2][0]);
            $this->View->Assign('head', $match[1][0] . $head . $match[3][0]);
        }
        else
        {
            $this->View->Assign('head', Zero_App::$Section->Name);
        }
        $this->View->Assign('HEADER_CONTENT', Zero_App::$Section->NameSub);
        $this->View->Assign('content', Zero_App::$Section->Content);

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
