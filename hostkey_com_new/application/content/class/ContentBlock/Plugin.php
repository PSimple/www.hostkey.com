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
        // Шаблон
        if ( isset($this->Params['view']) )
            $this->View = new Zero_View(__CLASS__ . '_' . $this->Params['view']);
        else
            $this->View = new Zero_View(__CLASS__);

        if ( isset($this->Params['IsFeatures']) )
        {
            $sql_where = "IsFeatures = 1";
        }
        else
        {
            $sql_where = "IsFeatures = 0";
        }
        $sql = "SELECT * FROM ContentBlock WHERE {$sql_where} AND Section_ID = " . Zero_App::$Section->ID;
        $data = Zero_DB::Select_Array($sql);
        $this->View->Assign('data', $data);

        return $this->View;
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
