<?php

/**
 * Текстовые контент-блоки на страницах.
 *
 * {plugin "Content_ContentBlock_Page" view="Content_ContentBlock_SelectServiceFeatures" IsFeatures="1"}
 *
 * @package Content.ContentBlock.Plugin
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.01.01
 */
class Content_ContentBlock_Page extends Zero_Controller
{
    /**
     * The compile tpl in string and out
     *
     * @var bool
     */
    protected $ViewTplOutString = true;

    /**
     * Вывод данных операции контроллера в шаблон
     *
     * @return bool
     */
    protected function Chunk_View()
    {
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
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Zero_Controller
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
