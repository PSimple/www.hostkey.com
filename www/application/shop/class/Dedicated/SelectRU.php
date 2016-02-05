<?php

/**
 * Dedicated
 *
 * Select Service
 *
 * @package Shop.Dedicated.Controller
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.07.20
 */
class Shop_Dedicated_SelectRU extends Zero_Controller
{
    /**
     * Контроллер по умолчанию.
     *
     * @return Zero_View
     */
    public function Action_Default()
    {
        $this->Chunk_Init();
        $this->Chunk_View();
        return $this->View;
    }

    /**
     * Вывод данных операции контроллера в шаблон
     *
     * Может быть переопределен конкретным контроллером
     *
     * @return bool
     */
    protected function Chunk_View()
    {
        $this->View->Assign("currency", 'eur');
        $this->View->Assign("currencyId", 2);
        if ( isset($this->Params['IsFeatures']) )
            $sql = "SELECT * FROM ContentBlock WHERE IsFeatures = 1 AND Section_ID = " . Zero_App::$Section->ID;
        else
            $sql = "SELECT * FROM ContentBlock WHERE IsFeatures = 0 AND Section_ID = " . Zero_App::$Section->ID;
        $need = Zero_DB::Select_Array($sql);
        $this->View->Assign('need_more' , $need );
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Dedicated_SelectRU
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
