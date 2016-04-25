<?php

/**
 * Cloud
 *
 * VpsStep1
 *
 * @package Shop.Controller.Cloud
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
        $config = Zero_Config::Get_Config('shop');
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
        $payment_period = ['monthly' => 0, 'quarterly' => 3, 'semiannually' => 6, 'annually' => 12];
        $p = $preset->getPreset($configuration, $payment_period);
        $table_row_data = [];
        $table_row_data['CPU Cores'] = [];
        foreach ($p as $key => $value)
        {
            if ( $value['hidden'] == 0 )
            {
                foreach ($value[0] as $kk => $vv)
                {
                    $table_row_data[$vv['name']][$key]['name'] = $vv['data'][0]['name'];
                    $table_row_data[$vv['name']][$key]['id'] = $vv['data'][0]['id'];
                    $table_row_data[$vv['name']][$key]['monthly'] = $vv['data'][0]['monthly'];
                }
            }
        }

        foreach ($p as $key_add_default => $val_add_default)
        {
            if ( $p[$key_add_default][0][696]['data'][0]['id'] == 'NONE' )
            {
                $configuration[696]['data'][$p[$key_add_default][0][696]['data'][0]['id']] = $p[$key_add_default][0][696]['data'][0];
            }
            if ( $p[$key_add_default][0][695]['data'][0]['id'] == 'NONE' )
            {
                $configuration[695]['data'][$p[$key_add_default][0][695]['data'][0]['id']] = $p[$key_add_default][0][695]['data'][0];
            }
            if ( $p[$key_add_default][0][693]['data'][0]['id'] == 'NONE' )
            {
                $configuration[693]['data'][$p[$key_add_default][0][693]['data'][0]['id']] = $p[$key_add_default][0][693]['data'][0];
            }
        }

        $arr_Backups_Limit[693] = $configuration[693]['data'];
        $arr_Bandwidth_Limit[695] = $configuration[695]['data'];
        $arr_VM_Template[696] = $configuration[696]['data'];

        $ttt = $table_row_data['The number of CPU sockets'];
        unset ($table_row_data['The number of CPU sockets']);
        $BWL = $table_row_data['Bandwidth Limit'];
        unset ($table_row_data['Bandwidth Limit']);
        $BKL = $table_row_data['Backups Limit'];
        unset ($table_row_data['Backups Limit']);
        $VMT = $table_row_data['VM Template'];
        unset ($table_row_data['VM Template']);

        $table_row_data['CPU Cores'] = $ttt;
        $table_row_data['CPANEL COMPATIBLE'] = [0, 0, 1, 1, 1];
        $table_row_data['Bandwidth Limit'] = $BWL;
        $table_row_data['Backups Limit'] = $BKL;
        $table_row_data['SOFTWARE'] = $VMT;

        if ( isset($this->Params['IsFeatures']) )
            $sql = "SELECT * FROM ContentBlock WHERE IsFeatures = 1 AND Section_ID = " . Zero_App::$Section->ID;
        else
            $sql = "SELECT * FROM ContentBlock WHERE IsFeatures = 0 AND Section_ID = " . Zero_App::$Section->ID;
        $need = Zero_DB::Select_Array($sql);
        $this->View->Assign('need_more', $need);

        $this->View->Assign('table_row_data', $table_row_data);
        $this->View->Assign('payment_period', $payment_period);
        $this->View->Assign('configuration', $p);
        $this->View->Assign('arr_Backups_Limit', $arr_Backups_Limit);
        $this->View->Assign('arr_Bandwidth_Limit', $arr_Bandwidth_Limit);
        $this->View->Assign('arr_VM_Template', $arr_VM_Template);
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
