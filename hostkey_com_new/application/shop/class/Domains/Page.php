<?php

/**
 * Domains
 *
 * Step1
 *
 * @package Shop.Domains
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.07.20
 */
class Shop_Domains_Page extends Zero_Controller
{
    /**
     * The compile tpl in string and out
     *
     * @var bool
     */
    protected $ViewTplOutString = true;

    /**
     * Контроллер по умолчанию.
     *
     * @return Zero_View
     */
    public function Action_Default()
    {
        $this->Chunk_Init();
        $this->Chunk_View();
        return $this->View->Fetch($this->ViewTplOutString);
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Domains_Page
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
