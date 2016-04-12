<?php

/**
 * Получение кеширонной информации по стоковым серверам.
 *
 * Согласно указанным параметрам (группы, валюта)
 * Загружает ранее закешированную конфигурцию
 *
 * @package Shop.Api.Dedicated
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-01-15
 */
class Shop_Dedicated_Api_ConfigStock extends Zero_Controller
{
    /**
     * Получение кеширонной конфигурации для кастомизатора указанного раздела
     *
     * @sample /api/v1/dedicated/config?currency=eur&groups=NL,Mini
     *
     * @return boolean flag статус выполнения
     */
    public function Action_GET()
    {
        // Проверки
        if ( !isset($_REQUEST['groups']) || !$_REQUEST['groups'] )
            Zero_App::ResponseJson500(-1, ["параметр групп не задан"]);
        else if ( !isset($_REQUEST['currency']) || !$_REQUEST['currency'] )
            Zero_App::ResponseJson500(-1, ["параметр валюта не задан"]);

        // Получаем конфигурацию
        $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorDedicatedStock/' . str_replace(',', '_', $_REQUEST['groups']) . '.data';
        if ( !file_exists($path) )
            Zero_App::ResponseJson500(-1, ["файл конфигурации не найден"]);
        $response = unserialize(file_get_contents($path));

        // Корректировка данных
        $min = 0;
        $max = 0;
        $responseSort = [];
        foreach ($response['Data'] as $compID => $row)
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
            // выбранная цена
            if ( 'eur' == $_REQUEST['currency'] )
                $row['Price']['Price'] = $row['Price']['PriceEUR'];
            else
                $row['Price']['Price'] = $row['Price']['PriceRUR'];
            // ditetime auction
            if ( $row['Auction']['DateTime'] )
            {   // если дата и время просрочены (кеш, консольное обновление)
                $d1 = new DateTime();
                $d2 = new DateTime($row['Auction']['DateTime']);
                $flag = $d1->diff($d2);
                if ( 0 < $flag->invert )
                {
                    $discount = $row['Price']['Price'] * $row['Auction']['Discount'];
                    $row['Price']['Price'] = $row['Price']['Price'] + $discount;
                    foreach (Shop_Config_General::$CurrencyPrice as $priceIndex)
                    {
                        $discount = $row['Price'][$priceIndex] * $row['Auction']['Discount'];
                        $row['Price'][$priceIndex] = $row['Price'][$priceIndex] + $discount;
                    }
                    $row['Auction']['Discount'] = 0;
                    $row['Auction']['DateTime'] = '';
                }
            }
            $row['Auction']['DateTime'] = app_datetimeGr($row['Auction']['DateTime']);
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
            $row['Raid'] = $flagRaid;
            //
            $responseSort['Data'][$compID] = $row;
        }
        $responseSort['CpuMinKpd'] = $min;
        $responseSort['CpuMaxKpd'] = $max;
        $responseSort['ComponentGroup'] = $response['ComponentGroup'];

        //        Zero_App::ResponseJson500(-1, ['ffff']);
        Zero_App::ResponseJson200($responseSort);
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Dedicated_Api_ConfigStock
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
