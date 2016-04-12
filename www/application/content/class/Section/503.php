<?php

/**
 * Контент страницы.
 *
 * Часто задаваемы вопросы
 *
 * @package Content.Controller.Section
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
        $Section = Zero_Section::Make();
        $Section->Init_Url("/404");
        $this->View->Assign('NAME', $Section->Name);
        $this->View->Assign('DESC', $Section->Description);
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
