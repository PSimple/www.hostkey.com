<?php

/**
 * Вывод новостей на сайте
 *
 * @package Content.Controller.News
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.06.09
 */
class Content_News_Page extends Zero_Controller
{
    /**
     * Контроллер по умолчанию.
     *
     * @return Zero_View
     * @throws Exception
     */
    public function Action_Default()
    {

        if ( 0 < count(Zero_App::$RequestParams) )
        {

            $this->View = new Zero_View(get_class($this) . 'Details');
            $news = Content_News::Make(Zero_App::$RequestParams[0]);
            $news->Load_Page();
            if ( !$news->ID )
                throw new Exception('Page Not Found', 404);
            $this->View->Assign('news', $news);
        }
        else
        {
            $this->Chunk_Init();
            $news = Content_News::Make();
            $news->AR->Sql_Order('DateCreate', 'DESC');
            $news->AR->Sql_Limit(1, 3);
            $newsList = $news->AR->Select_Array("ID, Name, Description, DATE_FORMAT(`DateCreate`, '%d.%m.%Y') Date, IsDetails");
            $this->View->Assign('newsList1', $newsList);
            $news->AR->Sql_Limit(2, 3);
            $newsList = $news->AR->Select_Array("ID, Name, Description, DATE_FORMAT(`DateCreate`, '%d.%m.%Y') Date, IsDetails");
            $this->View->Assign('newsList2', $newsList);
            $news->AR->Sql_Limit(3, 3);
            $newsList = $news->AR->Select_Array("ID, Name, Description, DATE_FORMAT(`DateCreate`, '%d.%m.%Y') Date, IsDetails");
            $this->View->Assign('newsList3', $newsList);
            $news->AR->Sql_Limit(4, 3);
            $newsList = $news->AR->Select_Array("ID, Name, Description, DATE_FORMAT(`DateCreate`, '%d.%m.%Y') Date, IsDetails");
            $this->View->Assign('newsList4', $newsList);
            $news->AR->Sql_Order('DateCreate', 'DESC');
            $news->AR->Sql_Limit(1, 12);
            $newsList = $news->AR->Select_Array("ID, Name, Description, DATE_FORMAT(`DateCreate`, '%d.%m.%Y') Date, IsDetails");
           // $NewsDetailPath = Zero_Config::Get_Config('content', 'config');
            $this->View->Assign('NEWS_DETAIL_PATH', Zero_Config::Get_Config('content')['NewsDetailPath']);
            $this->View->Assign('newsList', $newsList);
//            pre($newsList);
        }
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
        return $this->View ;
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
