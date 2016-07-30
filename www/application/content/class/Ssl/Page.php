<?php

/**
 * Ssl
 *
 * Page
 *
 * @package Shop.Controller.Ssl
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.07.20
 */
class Content_Ssl_Page extends Zero_Controller
{
    /**
     * Контроллер по умолчанию.
     *
     * @return Zero_View
     */
    public function Action_Default()
    {
        $this->Chunk_Init();

//        $target = 'IS NULL';
//        if ( isset($this->Params['target']) )
//            $target = "= '{$this->Params['target']}'";
        $sql = "SELECT * FROM ContentBlock WHERE Target = 'ssl1' AND IsEnable = 1 AND Section_ID = " . Zero_App::$Section->ID . " ORDER BY Sort ASC";
        $data = Zero_DB::Select_Array($sql);
        $this->View->Assign('arrSsl1', $data);

        $sql = "SELECT * FROM ContentBlock WHERE Target = 'ssl2' AND IsEnable = 1 AND Section_ID = " . Zero_App::$Section->ID . " ORDER BY Sort ASC";
        $data = Zero_DB::Select_Array($sql);
        $this->View->Assign('arrSsl2', $data);

        $sql = "SELECT * FROM ContentBlock WHERE Target = 'ssl3' AND IsEnable = 1 AND Section_ID = " . Zero_App::$Section->ID . " ORDER BY Sort ASC";
        $data = Zero_DB::Select_Array($sql);
        $this->View->Assign('arrSsl3', $data);

        return $this->View;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Content_Ssl_Page
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
