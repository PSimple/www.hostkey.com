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
class Shop_Cloud_VdsStep1 extends Zero_Controller
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
        $config = Zero_Config::Get_Config('shop', 'config');
        $this->View->Assign("currency", $config['currency']);
        $this->View->Assign("currencyId", $config['currencyId']);

        $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorCloudCustom/' . md5($config['currencyId'] . 530) . '.data';
        $configuration = [];
        if ( file_exists($path) )
        {
            $configuration = unserialize(file_get_contents($path));
        }
        //ksort( $configuration );
       //pre( $configuration );
/*
        $configuration[696]['data'][0]['monthly'] = 1;
        $configuration[696]['data'][0]['quarterly'] = 3;
        $configuration[696]['data'][0]['semiannually'] = 6;
        $configuration[696]['data'][0]['annually'] = 12;

        $configuration[700]['data'][0]['monthly'] = 100;
        $configuration[700]['data'][0]['quarterly'] = 300;
        $configuration[700]['data'][0]['semiannually'] = 600;
        $configuration[700]['data'][0]['annually'] = 1200;
        $configuration[700]['name'] = "TEst";
        $configuration[700]['hidden'] = 1;
        $configuration[700]['data'][0]['id'] = 10000;
        $configuration[700]['data'][0]['name'] = "test VM";
        $configuration[700]['data'][0]['value'] = "value TEST VM";

        $configuration[700]['data'][1]['monthly'] = 10;
        $configuration[700]['data'][1]['quarterly'] = 30;
        $configuration[700]['data'][1]['semiannually'] = 60;
        $configuration[700]['data'][1]['annually'] = 120;
        $configuration[700]['data'][1]['id'] = 1000000;
        $configuration[700]['data'][1]['name'] = "test VM1";
        $configuration[700]['data'][1]['value'] = "value TEST VM1";
*/
       // $configuration[696]['hidden'] = "1";
      //  pre( $configuration );
        $this->View->Assign('configuration', $configuration);
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Cloud_VdsStep1
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
