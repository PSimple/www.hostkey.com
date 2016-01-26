<?php

/**
 * Сток
 *
 * @package Shop.Basket
 * @author
 * @date 2015.05.20
 */
class Shop_Basket_Stock extends Zero_Controller
{
    /**
     * Some action.
     *
     * @return boolean flag stop execute of the next chunk
     * @see /mainpage.php
     */
    public function Action_Default()
    {
        $this->View = new Zero_View(__CLASS__);

        $data = [];
        if ( isset($this->Params['Groups']) && $this->Params['Groups'] )
            $data = Shop_Price::Get_Stock($this->Params['Groups'], $this->Params['Currency']);

        foreach($data as $key => $row)
        {
            // CPU KPD
            $cnt_cpu = 1;
            if ( preg_match("~2x|2 x~si", $row['Cpu']['Name']) )
                $cnt_cpu++;
            else if ( preg_match("~3x|3 x~si", $row['Cpu']['Name']) )
                $cnt_cpu++;
            //
            $stars_display = '';
            for ($j = 0; $j < 30000; $j += 1000)
            {
                if ( $j <= $row['Cpu']['Kpd'] * 2 )
                    $stars_display .= '<img src="/images/starsZ.png" title="Performance per CPU: ' . $row['Cpu']['Kpd'] . ', total: ' . ($row['Cpu']['Kpd'] * $cnt_cpu) . '">';
                else
                    $stars_display .= '<img src="/images/starsB.png" title="Performance per CPU: ' . $row['Cpu']['Kpd'] . ', total: ' . ($row['Cpu']['Kpd'] * $cnt_cpu) . '">';
            }
            if ( $row['Cpu']['KpdLink'] )
                $stars_display = '<a href="' . $row['Cpu']['KpdLink'] . '" target="_blank">' . $stars_display . '</a>';
            if ( 2 == $cnt_cpu )
                $stars_display .= '</br>' . $stars_display;
            else if ( 3 == $cnt_cpu )
                $stars_display .= '</br>' . $stars_display . '</br>' . $stars_display;
            $data[$key]['Cpu']['Visual'] = $stars_display;

            // RAID (Other)
            $flagRaid = '';
            if ( isset($row['Other']) )
            {
                foreach($row['Other'] as $v)
                {
                    if ( preg_match('~Adaptec|LSI|RS2|SRC|RAID|SAS~s', $v) )
                    {
                        $flagRaid = '<img src="/images/tick.png">';
                        break;
                    }
                }
            }
            $data[$key]['Raid'] = $flagRaid;
        }
        //        pre($data);

        $this->View->Assign('currency', $this->Params['Currency']);
        $this->View->Assign('groups', $this->Params['Groups']);
        $this->View->Assign('Result', $data);
        return $this->View;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param string $className заглушка
     * @param array $properties входные параметры плагина
     * @return Shop_Basket_Stock
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

    /**
     * Фабричный метод по созданию контроллера.
     *
     * Работает через сессию.
     * Индекс: $class_name
     *
     * @param string $className заглушка
     * @param array $properties входные параметры контроллера
     * @return Shop_Basket_Stock
     */
    public static function Factor($properties = [])
    {
        if ( !$result = Zero_Session::Get(__CLASS__) )
        {
            $result = self::Make($properties);
            Zero_Session::Set(__CLASS__, $result);
        }
        return $result;
    }
}
