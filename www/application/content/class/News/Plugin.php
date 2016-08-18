<?php

/**
 * Вывод новостей на сайте
 *
 * @package Content.Controller.News
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.06.09
 */
class Content_News_Plugin extends Zero_Controller
{
    /**
     * Контроллер по умолчанию.
     *
     * @return Zero_View
     * @throws Exception
     */
    public function Action_Default()
    {
        $this->Chunk_Init();
        $news = Content_News::Make();
        $news->AR->Sql_Order('DateCreate', 'DESC');
        $news->AR->Sql_Limit(1, 4);
        $newsList = $news->AR->Select_Array("ID, Name, Description, DATE_FORMAT(`DateCreate`, '%d.%m.%Y') Date, IsDetails");
        $this->View->Assign('NEWS_DETAIL_PATH', Zero_App::$Config->Modules['content']['NewsDetailPath']);
        $this->View->Assign('newsList', $newsList);
        $this->View->Assign('H1', Zero_App::$Section->Name);
        return $this->View;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Content_News_Plugin
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
