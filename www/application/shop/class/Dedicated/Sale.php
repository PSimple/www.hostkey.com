<?php

/**
 * Продажи стока
 *
 * @package Shop.Dedicated
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016-02-04
 */
class Shop_Dedicated_Sale extends Zero_Controller
{
    /**
     * Контроллер по умолчанию.
     *
     * @return Zero_View
     */
    public function Action_Default()
    {
        $this->Chunk_Init();

        $config = Zero_Config::Get_Config('shop', 'config');
        $this->View->Assign("currency", 'eur');
        $this->View->Assign("currencyId", 2);

        $min = 0;
        $max = 0;
        $configuration = [];
        $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorDedicatedStock/All.data';
        if ( file_exists($path) )
        {
            $configuration = unserialize(file_get_contents($path));
            foreach ($configuration['Data'] as $key => $row)
            {
                // min
                if ( 0 == $min )
                    $min = $row['Cpu']['Kpd'];
                else if ( $row['Cpu']['Kpd'] < $min )
                    $min = $row['Cpu']['Kpd'];
                // max
                if ( 0 == $max )
                    $max = $row['Cpu']['Kpd'];
                else if ( $row['Cpu']['Kpd'] > $max )
                    $max = $row['Cpu']['Kpd'];
                // CPU KPD
                $cnt_cpu = 1;
                if ( preg_match("~2x|2 x~si", $row['Cpu']['Name']) )
                    $cnt_cpu++;
                else if ( preg_match("~3x|3 x~si", $row['Cpu']['Name']) )
                    $cnt_cpu++;
                $configuration['Data'][$key]['Cpu']['Cnt'] = $cnt_cpu;
                // RAID (Other)
                $flagRaid = false;
                if ( isset($row['Other']) )
                {
                    foreach ($row['Other'] as $v)
                    {
                        if ( preg_match('~Adaptec|LSI|RS2|SRC|RAID|SAS~s', $v) )
                        {
                            $flagRaid = true;
                            break;
                        }
                    }
                }
                $configuration['Data'][$key]['Raid'] = $flagRaid;
            }
        }
        $this->View->Assign('min', $min);
        $this->View->Assign('max', $max);
        $this->View->Assign('configuration', $configuration['Data']);
//        pre($configuration);

        // OS
        $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorList/4.data';
        $listOs = [];
        if ( file_exists($path) )
        {
            $listOs = unserialize(file_get_contents($path));
        }
        $this->View->Assign('listOs', $listOs);

        // Port
        $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorList/13.data';
        $listPort = [];
        if ( file_exists($path) )
        {
            $listPort = unserialize(file_get_contents($path));
        }
        $this->View->Assign('listPort', $listPort);

        return $this->View;
    }

    /**
     * Инициализация операции контроллера до его выполнения
     *
     * Может быть переопределен конкретным контроллером
     *
     * @return bool
     */
    protected function Chunk_Init()
    {
        // Шаблон
        if ( isset($this->Params['view']) )
            $this->View = new Zero_View($this->Params['view']);
        else if ( isset($this->Params['tpl']) )
            $this->View = new Zero_View($this->Params['tpl']);
        else if ( isset($this->Params['template']) )
            $this->View = new Zero_View($this->Params['template']);
        else
            $this->View = new Zero_View(get_class($this));
        // Модель (пример)
        // $this->Model = Zero_Model::Makes('Zero_Users');
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Dedicated_Sale
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
