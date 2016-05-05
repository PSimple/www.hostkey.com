<?php

/**
 * Текстовые контент-блоки на страницах.
 *
 * {plugin "Content_ContentLittle_Plugin" view="Page"}
 *
 * @package Content.Plugin.ContentLittle
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.11.19
 */
class Content_ContentLittle_Plugin extends Zero_Controller
{
    /**
     * Контроллер по умолчанию.
     *
     * @return Zero_View
     */
    public function Action_Default()
    {
        // Шаблон
        $this->Chunk_Init();
        if ( 'Header' == $this->Params['view'] )
        {
            $sql = "SELECT ID, Value FROM ContentLittle WHERE ID = 1";
            $data = Zero_DB::Select_List_Index($sql);
            $this->View->Assign('data', $data);
            $this->View->Assign('SECTION_ID', Zero_App::$Section->Section_ID);
        }
        else if ( 'Footer' == $this->Params['view'] )
        {
            $sql = "SELECT ID, Value FROM ContentLittle WHERE ID IN (2,3,4)";
            $data = Zero_DB::Select_List_Index($sql);
            $this->View->Assign('data', $data);
        }
        else if ( 'FooterMain' == $this->Params['view'] )
        {
            $sql = "SELECT ID, Value FROM ContentLittle WHERE ID IN (2,3,4)";
            $data = Zero_DB::Select_List_Index($sql);
            $this->View->Assign('data', $data);
        }
        return $this->View;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Content_ContentLittle_Plugin
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
