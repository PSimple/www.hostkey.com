<?php

/**
 * Вывод новостей на сайте
 *
 * @package Content.News.Controller
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.06.09
 */
class Content_News_Page extends Zero_Controller
{
    /**
     * Контроллер по умолчанию.
     *
     * @return Zero_View
     */
    public function Action_Default()
    {
        if ( 0 < count(Zero_App::$RequestParams) )
        {
            $view = new Zero_View(get_class($this) . 'Details');
            $news = Content_News::Make(Zero_App::$RequestParams[0]);
            $news->Load_Page();
            $view->Assign('news', $news);
        }
        else
        {
            $view = new Zero_View(get_class($this));
            $news = Content_News::Make();
            $news->AR->Sql_Order('DateCreate', 'DESC');
            $news->AR->Sql_Limit(1, 3);
            $newsList = $news->AR->Select_Array("ID, Name, Description, DATE_FORMAT(`DateCreate`, '%d.%m.%Y') Date, IsDetails");
            $view->Assign('newsList1', $newsList);
            $news->AR->Sql_Limit(2, 3);
            $newsList = $news->AR->Select_Array("ID, Name, Description, DATE_FORMAT(`DateCreate`, '%d.%m.%Y') Date, IsDetails");
            $view->Assign('newsList2', $newsList);
            $news->AR->Sql_Limit(3, 3);
            $newsList = $news->AR->Select_Array("ID, Name, Description, DATE_FORMAT(`DateCreate`, '%d.%m.%Y') Date, IsDetails");
            $view->Assign('newsList3', $newsList);
            $news->AR->Sql_Limit(4, 3);
            $newsList = $news->AR->Select_Array("ID, Name, Description, DATE_FORMAT(`DateCreate`, '%d.%m.%Y') Date, IsDetails");
            $view->Assign('newsList4', $newsList);
        }
        return $view;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Content_News_Page
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
