<?php

/**
 * Текстовые контент-блоки на страницах.
 *
 * {plugin "Content_ContentBlock_Plugin" view="Page" IsFeatures="1"}
 *
 * @package Content.ContentBlock.Plugin
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.01.01
 */
class Content_ContentBlock_Plugin extends Zero_Controller
{
    /**
     * Контроллер по умолчанию.
     *
     * @return Zero_View
     */
    public function Action_Default()
    {
        $this->Chunk_Init();
        if ( isset($this->Params['IsFeatures']) )
            $sql = "SELECT * FROM ContentBlock WHERE IsFeatures = 1 AND IsEnable = 1 AND Section_ID = " . Zero_App::$Section->ID;
        else
            $sql = "SELECT * FROM ContentBlock WHERE IsFeatures = 0 AND IsEnable = 1 AND Section_ID = " . Zero_App::$Section->ID;

        $data = Zero_DB::Select_Array($sql);
        $this->View->Assign('DATA', $data);
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
            $this->View = new Zero_View(get_class($this) . '_' . $this->Params['view']);
        else
            $this->View = new Zero_View(get_class($this));
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Content_ContentBlock_Plugin
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
