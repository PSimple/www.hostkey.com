<?php

/**
 * Cloud
 *
 * Manager
 *
 * @package Shop.Cloud
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.07.20
 */
class Shop_Cloud_Manager extends Zero_Controller
{



    /**
     *
     * @return Zero_View
     */
    public function Action_Default()
    {
        //$this->Chunk_Init();
        $this->View = new Zero_View('Shop_Cloud_Manager');
        $this->Chunk_View();
        return $this->View;
    }


    /**
     * Вывод данных операции контроллера в шаблон
     *
     *
     * @return bool
     */
    protected function Chunk_View()
    {
        $this->View->Assign("currency", $currencyId = Zero_App::$Config->Modules['shop']['currency']);
        $this->View->Assign("currencyId", $currencyId = Zero_App::$Config->Modules['shop']['currencyId']);
        $this->View->Assign("PID", 531);
        $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorCloudCustom/' . md5($currencyId = Zero_App::$Config->Modules['shop']['currencyId'] . 531) . '.data';
        $configuration = [];
        if ( file_exists($path) )
        {
            $configuration = unserialize(file_get_contents($path));
        }
        $preset = Shop_PresetContainerVPS::Make();
        $payment_period = 'monthly';
        $p = $preset->getPreset( $configuration, $payment_period);
        sort( $p );
        $this->View->Assign('table_row_data', $table_row_data );
        $this->View->Assign('payment_period', $payment_period );
        $this->View->Assign('configuration', $p );
        return true;
    }


    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Cloud_Manager
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
