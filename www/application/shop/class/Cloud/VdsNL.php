<?php

/**
 * Cloud
 *
 * VdsStep1
 *
 * @package Shop.Controller.Cloud
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.07.20
 */
class Shop_Cloud_VdsNL extends Zero_Controller
{
    /**
     * Контроллер по умолчанию.
     *
     * @return Zero_View
     */
    public function Action_Default()
    {
        $this->View = new Zero_View('Shop_Cloud_VDS');
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
        $PID = 531;
        $this->View->Assign("currency", $currencyId = Zero_App::$Config->Modules['shop']['currency']);
        $this->View->Assign("currencyId", $currencyId = Zero_App::$Config->Modules['shop']['currencyId']);
        $this->View->Assign("PID", $PID);
        $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorCloudCustom/' . md5($currencyId = Zero_App::$Config->Modules['shop']['currencyId'] . $PID) . '.data';
        $configuration = [];
        if ( file_exists($path) )
        {
            $configuration = unserialize(file_get_contents($path));
        }
        $preset = Shop_PresetContainerVPS::Make();
        $configuration = $preset->getSortCloudVDS($configuration, $PID);
        $this->View->Assign('configuration', $configuration);

        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Cloud_VdsNL
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
