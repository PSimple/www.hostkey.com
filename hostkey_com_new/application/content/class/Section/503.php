<?php

/**
 * Контент страницы.
 *
 * Часто задаваемы вопросы
 *
 * @package Content.Section.Controller
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.07.20
 */
class Content_Section_503 extends Zero_Controller
{
    /**
     * Контроллер по умолчанию.
     *
     * @return Zero_View
     */
    public function Action_Default()
    {
        $this->Chunk_Init();
        $Section = Zero_Model::Makes('Zero_Section');
        $Section->Init_Url("/503");
        $section_data = $Section->Get_Props();
        preg_match_all('#(<.+?>)(.+?)(<\/.+?>)#is', $section_data['Name'], $match);
        $head = str_replace(' ', '<br>', $match[2][0]);
        $this->View->Assign('NAME', $match[1][0] . $head . $match[3][0]);
        $this->View->Assign('DESC', $section_data['Description']);
        return $this->View;
    }

    /**
     * Инициализация контроллера
     *
     * Может быть переопределен конкретным контроллером
     *
     * @return bool
     */
    protected function Chunk_Init()
    {
        // Шаблон
        if ( isset($this->Params['view']) )
            $this->View = new Zero_View($this->Params['view']);
        else if ( isset($this->Params['tpl']) )
            $this->View = new Zero_View($this->Params['tpl']);
        else if ( isset($this->Params['template']) )
            $this->View = new Zero_View($this->Params['template']);
        else
            $this->View = new Zero_View(get_class($this));
        // Модель (пример)
        // $this->Model = Zero_Model::Makes('Zero_Users');
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Content_Section_Faq
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
