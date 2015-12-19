<?php

/**
 * Cloud
 *
 * VdsStep1
 *
 * @package Shop.Cloud
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.07.20
 */
class Shop_Cloud_VdsRU extends Zero_Controller
{
    /**
     * Контроллер по умолчанию.
     *
     * @return Zero_View
     */
    public function Action_Default()
    {
       // $this->Chunk_Init();
      //  pre($this->View );
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
        $PID = 539;
        $config = Zero_Config::Get_Config('shop', 'config');
        $this->View->Assign("currency", $config['currency']);
        $this->View->Assign("currencyId", $config['currencyId']);
        $this->View->Assign("PID", $PID);
        $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorCloudCustom/' . md5($config['currencyId'] . $PID) . '.data';
        $configuration = [];
        if ( file_exists($path) )
        {
            $configuration = unserialize(file_get_contents($path));
        }
        $preset = Shop_PresetContainerVPS::Make();
        $configuration = $preset -> getSortCloudVDS ( $configuration,$PID  );
        $this->View->Assign('configuration', $configuration);
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Cloud_VdsRU
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