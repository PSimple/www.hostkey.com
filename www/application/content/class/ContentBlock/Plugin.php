<?php

/**
 * Текстовые контент-блоки на страницах.
 *
 * {plugin "Content_ContentBlock_Plugin" view="Page" IsFeatures="1"}
 *
 * @package Content.Plugin.ContentBlock
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

        $target = 'IS NULL';
        if ( isset($this->Params['target']) )
            $target = "= '{$this->Params['target']}'";
        $sql = "SELECT * FROM ContentBlock WHERE Target {$target} AND IsEnable = 1 AND Section_ID = " . Zero_App::$Section->ID;

        pre($this->Params['view'], $sql);

        $data = Zero_DB::Select_Array($sql);
        $this->View->Assign('DATA', $data);
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
