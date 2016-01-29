<?php

/**
 * Получение кеширонной конфигурации для кастомизатора (Dedicated)
 *
 * Получение кеширонной конфигурации для кастомизатора по указанным параметрам
 * Загружает ранее закешированную конфигурцию
 *
 * @package Shop.Dedicated.Api
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-11-28
 */
class Shop_Dedicated_Api_ConfigCustom extends Zero_Controller
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
        if ( !isset($_REQUEST['groups']) || !$_REQUEST['groups'] )
            Zero_App::ResponseJson200(null, -1, ["параметр групп не задан"]);
        else if ( !isset($_REQUEST['currency']) || !$_REQUEST['currency'] )
            Zero_App::ResponseJson200(null, -1, ["параметр валюта не задан"]);

        $path = ZERO_PATH_EXCHANGE . '/ConfigCalculatorDedicated/' . md5($_REQUEST['currency'] . $_REQUEST['groups']) . '.data';
        if ( !file_exists($path) )
            Zero_App::ResponseJson200(null, -1, ["файл конфигурации не найден"]);

        Zero_Logs::File('Shop_Dedicated_Api_ConfigCustom', $path);
        $response = unserialize(file_get_contents($path));

        // Заплатка для правильно сортировки
        $responseSort = [];
        foreach ($response['Data'] as $componentTypeID => $rows)
        {
            foreach ($rows as $row)
            {
                $responseSort['Data'][$componentTypeID][] = $row;
            }
        }

        Zero_App::ResponseJson200($responseSort);
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Dedicated_Api_ConfigCustom
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
