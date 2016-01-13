<?php

/**
 * Cloud
 *
 * VpsStep1
 *
 * @package Shop.Cloud
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.07.20
 */
class Shop_Cloud_ContainerVPS extends Zero_Controller
{
    /**
     *
     * @return Zero_View
     */
    public function Action_Default()
    {
        //$this->Chunk_Init();
        $this->View = new Zero_View('Shop_Cloud_VPS');
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
        $config = Zero_Config::Get_Config('shop', 'config');
        $this->View->Assign("currency", $config['currency']);
        $this->View->Assign("currencyId", $config['currencyId']);
        $this->View->Assign("PID", 530);
        $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorCloudCustom/' . md5($config['currencyId'] . 530) . '.data';
        $configuration = [];
        if ( file_exists($path) )
        {
            $configuration = unserialize(file_get_contents($path));
        }

        $preset = Shop_PresetContainerVPS::Make();
        $payment_period = ['monthly'=> 0, 'quarterly' => 3, 'semiannually' => 6, 'annually' => 12];
        $p = $preset->getPreset($configuration, $payment_period);
        $table_row_data = array();
        foreach ($p as $key => $value)
        {
            foreach ($value as $k => $v)
            {
                if ( $v['hidden'] == 0 )
                {
                    foreach ($v as $kk => $vv)
                    {

                            $table_row_data[$vv['name']][$key]['name'] = $vv['data'][0]['name'];
                            $table_row_data[$vv['name']][$key]['id'] = $vv['data'][0]['id'];

                    }
                }
            }
        }

        $arr_VM_Template['696'] = $configuration['696']['data'];

    // pre ( json_encode( $table_row_data ) ); die;


        $this->View->Assign('table_row_data', $table_row_data);
        $this->View->Assign('payment_period', $payment_period);
        $this->View->Assign('configuration', $p);
        $this->View->Assign('arr_VM_Template' , $arr_VM_Template );

        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Cloud_ContainerVPS
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
