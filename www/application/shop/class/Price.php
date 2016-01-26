<?php

/**
 * Controller. <Comment>
 *
 * @package <Package>.<Subpackage>.Controller
 * @author
 * @version $Id$
 */
class Shop_Price
{
    /**
     * Получение пресетов по группам
     *
     * @param string $groups группы
     * @param string $currency валюта
     * @param int $compId идентификатор оборудования
     * @return array
     */
    public static function Get_Set($groups, $currency, $compId = 0)
    {
        $data = Zero_App::RequestJson('GET', 'https://ug.hostkey.ru/api/v1.0/inv/component1/set?groups=' . $groups . '&compId=' . $compId . "&currency=" . $currency);
        if ( !isset($data['Content']) )
            $data['Content'] = [];
        return $data['Content'];
    }

    /**
     * Получение продажных компоннетов для построения кастомизатора по указанным группам
     *
     * @param string $groups группы компонентов
     * @param string $currency валюта
     * @return array
     */
    public static function Get_Data($groups, $currency)
    {
        $data = Zero_App::RequestJson('GET', 'https://ug.hostkey.ru/api/v1.0/inv/component/sale?groups=' . $groups . "&currency=" . $currency);
        if ( !isset($data['Content']) )
            $data['Content'] = [];
        foreach ($data['Content'] as $key => $val)
        {
            if ( !is_array($val) )
            {
                continue;
            }
            foreach ($val as $k => $v)
            {
                $options = [];
                foreach (explode(';', $v['Options']) as $opt)
                {
                    if ( !$opt = trim($opt) )
                        continue;
                    $arr = explode('=', $opt);
                    if ( count($arr) == 2 )
                        $options[$arr[0]] = $arr[1];
                }
                if ( $key == 1 )
                {
                    if ( !isset($v['cpu_count']) )
                        $options['cpu_count'] = 1;
                }
                if ( !isset($options['short_name']) || $options['short_name'] == '' )
                    $options['short_name'] = $data['Content'][$key][$k]['Name'];
                $data['Content'][$key][$k]['Options'] = $options;
                // выбранная валюта
                if ( 'eur' == $currency )
                {
                    $data['Content'][$key][$k]['Price'] = $data['Content'][$key][$k]['PriceEUR'];
                }
                else
                {
                    $data['Content'][$key][$k]['Price'] = $data['Content'][$key][$k]['PriceRUR'];
                }
            }
        }

        if ( !isset($data['Content'][14]) )
            $data['Content'][14] = [];
        if ( !isset($data['Content'][18]) )
            $data['Content'][18] = [];

        //        if ( 1 == count($data['Content'][6]) )
        //        {
        //            $data['Content'][6] = [reset($data['Content'][6])];
        //        }
//        Zero_Logs::File("SetStock.log", $data['Content']);
        return $data['Content'];
    }

    /**
     * Получение стока по группам
     *
     * @param string $groups группы
     * @param string $currency валюта
     * @param int $compId идентификатор оборудования
     * @return array
     */
    public static function Get_Stock($groups, $currency, $compId = 0)
    {
        $data = Zero_App::RequestJson('GET', 'https://ug.hostkey.ru/api/v1.0/inv/component1/stock?groups=' . $groups . '&compId=' . $compId . "&currency=" . $currency);
        if ( !isset($data['Content']) )
            $data['Content'] = [];
        return $data['Content'];
    }
}
