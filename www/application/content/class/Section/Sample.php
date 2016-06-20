<?php

/**
 * <Comment>
 *
 * {plugin "Zero_Section_SeoTag" view="Zero_Section_SeoTag"}
 *
 * @package Content.Section
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date <Date>
 */
class Content_Section_Sample extends Zero_Controller
{
    /**
     * Контроллер по умолчанию.
     *
     * @return string
     */
    public function Action_Default()
    {
        $this->Chunk_Init();

        $this->View->Assign('Price', 234.56);
        $this->View->Assign('flag', false);
        $this->View->Assign('other', 'DOPOLNITEKNO');
        $this->View->Assign('Header', 'FIRMA VENIKOV NE VYAJET');
        $this->View->Assign('itemList', ['popcorn' => 234, 'funtik', 'fantik', 'musya', 'rewuyruewtruetruet']);
        $this->View->Assign('itemList2', [
                ['Price' => 234, 'Name' => 'fantik', 'Description' => 'Description'],
                ['Price' => 234, 'Name' => 'fantik', 'Description' => 'Description'],
                ['Price' => 234, 'Name' => 'fantik', 'Description' => 'Description'],
                ['Price' => 234, 'Name' => 'fantik', 'Description' => 'Description'],
                ['Price' => 234, 'Name' => 'fantik', 'Description' => 'Description'],
            ]);

        $this->Chunk_View();
        return $this->View;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Content_Section_Sample
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
