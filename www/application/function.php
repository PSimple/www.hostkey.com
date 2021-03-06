<?php
/**
 * Функции общего назначения конкретного проекта
 *
 * @package Function
 */
function app_route()
{
    $Url = '/';
    $Lang = Zero_App::$Config->Site_Language;
    $Mode = Zero_App::MODE_WEB;

    // если запрос консольный
    if ( !isset($_SERVER['REQUEST_URI']) )
    {
        $Mode = Zero_App::MODE_CONSOLE;
        return [$Mode, $Lang, $Url];
    }

    // главная страница
    if ( $_SERVER['REQUEST_URI'] == '/' )
        return [$Mode, $Lang, $Url];

    // инициализация
    $Url = '';
    if ( substr($_SERVER['REQUEST_URI'], -1) == '/' )
    {
        $_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], 0, -1);
    }
    app_redirect($_SERVER['REQUEST_URI']);
    $row = explode('/', strtolower(rtrim(ltrim(explode('?', $_SERVER['REQUEST_URI'])[0], '/'), '/')));

    // язык
    if ( $Lang != $row[0] && isset(Zero_App::$Config->Language[$row[0]]) )
    {
        $Lang = array_shift($row);
        $Url = '/' . $Lang;
        if ( count($row) == 0 )
            return [$Mode, $Lang, $Url];
    }

    // api
    if ( strtolower(Zero_App::MODE_API) == $row[0] || strtolower(Zero_App::MODE_API) == Zero_App::$Config->Site_DomainSub )
    {
        $Mode = Zero_App::MODE_API;
        app_request_data_api();
    }

    // чпу параметры
    $p = array_pop($row);
    $p = explode('.', $p)[0];
    $p = explode('_', $p);
    if ( 1 < count($p) )
        Zero_App::$RequestParams = explode('-', $p[1]);
    $row[] = $p[0];

    // uri
    $Url .= '/' . implode('/', $row);
    return [$Mode, $Lang, $Url];
}

function app_request_data_api()
{
    // Инициализация входных параметров и данных в случае api
    if ( $_SERVER['REQUEST_METHOD'] === "PUT" )
    {
        $data = file_get_contents('php://input', false, null, -1, $_SERVER['CONTENT_LENGTH']);
        $_REQUEST = json_decode($data, true);
    }
    else if ( $_SERVER['REQUEST_METHOD'] === "POST" && isset($GLOBALS["HTTP_RAW_POST_DATA"]) )
    {
        $_REQUEST = json_decode($GLOBALS["HTTP_RAW_POST_DATA"], true);
    }
}

function app_redirect($uri)
{
    $data = [];
    if ( file_exists($path = ZERO_PATH_SITE . '/redirect.ini') )
        $data = parse_ini_file($path);
    else if ( file_exists($path = ZERO_PATH_EXCHANGE . '/redirect.ini') )
        $data = parse_ini_file($path);
    if ( isset($data[$uri]) && $data[$uri] != "404" )
    {
        Zero_App::ResponseRedirect($data[$uri]);
    }
}

function app_datetimeGr($datetime)
{
    if ( !$datetime )
        return '';
    $a = explode(' ', $datetime);
    return $a[0] . 'T' . $a[1] . 'Z';
}
