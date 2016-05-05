<?php

/**
 * Часто задаваемы вопросы по Ssl
 *
 * @sample {plugin "Content_FaqSsl_Plugin" view="Page"}
 *
 * @package Content.Plugin.FaqSsl
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.07.20
 */
class Content_FaqSsl_Plugin extends Zero_Controller
{
    /**
     * Контроллер по умолчанию.
     *
     * @return Zero_View
     */
    public function Action_Default()
    {
        $this->Chunk_Init();

        $sql = "SELECT * FROM FaqSsl ORDER BY Sort ASC";
        $rows = Zero_DB::Select_Array($sql);
        $this->View->Assign('rows', $rows);

        return $this->View;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Content_FaqSsl_Plugin
     */
    public static function Make($properties = [])
    {
        $Controller = new self();
        foreach ($properties as $property => $value) {
            $Controller->Params[$property] = $value;
        }
        return $Controller;
    }
}
