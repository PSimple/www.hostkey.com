<?php

/**
 * Получение кеширонной конфигурации для калькулятора (по группам)
 *
 * Получение кеширонной конфигурации для кастомизатора по указанным параметрам
 * Загружает ранее закешированную конфигурцию
 *
 * @package Shop.Api.Dedicated
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016-02-04
 */
class Shop_Dedicated_Api_Custom extends Zero_Controller
{
    /**
     * Получение кеширонной конфигурации для калькулятора (по группам)
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
        $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorDedicated/' . str_replace(',', '_', $_REQUEST['groups']) . '.data';
        if ( !file_exists($path) )
        {
            $url = Shop_Config_General::URL_API_INVENTORY . "/api/v1.0/inv/component/salenew?groups={$_REQUEST['groups']}";
            $data = Zero_App::RequestJson("GET", $url);
            if ( false == $data['ErrorStatus'] && isset($data['Content']) )
            {
                $data['Content']['ComponentGroup'] = $_REQUEST['groups'];
                $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorDedicated/' . str_replace(',', '_', $_REQUEST['groups']) . '.data';
                Zero_Helper_File::File_Save($path, serialize($data['Content']));
            }
            else
            {
                Zero_App::ResponseJson500(-1, ["не удалось получить конфигурацию"]);
            }
        }
        $response = unserialize(file_get_contents($path));

        // Заплатка для правильной сортировки и инициализация выбранной цены
        $responseSort = [];
        foreach ($response['Data'] as $componentTypeID => $rows)
        {
            foreach ($rows as $row)
            {
                if ( 'eur' == $_REQUEST['currency'] )
                {
                    $row['Price'] = $row['PriceEUR'];
                    if ( 138 == $row['ID'] )
                        $response['CostLicenseWin'] = $row['PriceEUR'];
                }
                else
                {
                    $row['Price'] = $row['PriceRUR'];
                    if ( 138 == $row['ID'] )
                        $response['CostLicenseWin'] = $row['PriceRUR'];
                }
                $responseSort['Data'][$componentTypeID][] = $row;
            }
        }
        if ( !isset($responseSort['Data'][14]) )
            $responseSort['Data'][14] = [];
        if ( !isset($responseSort['Data'][18]) )
            $responseSort['Data'][18] = [];
        if ( !isset($responseSort['Data'][1]) )
            $responseSort['Data'][1] = [];
        if ( !isset($responseSort['Data'][2]) )
            $responseSort['Data'][2] = [];
        if ( !isset($responseSort['Data'][3]) )
            $responseSort['Data'][3] = [];
        if ( !isset($responseSort['Data'][6]) )
            $responseSort['Data'][6] = [];
        if ( !isset($responseSort['Data'][8]) )
            $responseSort['Data'][8] = [];
        if ( !isset($responseSort['Data'][21]) )
            $responseSort['Data'][21] = [];

        $responseSort['CostLicenseWin'] = $response['CostLicenseWin'];
        $responseSort['EURRUR'] = $response['EURRUR'];
        $responseSort['Currency'] = $_REQUEST['currency'];
        $responseSort['ComponentGroup'] = $response['ComponentGroup'];

        Zero_App::ResponseJson200($responseSort);
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Dedicated_Api_Custom
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
