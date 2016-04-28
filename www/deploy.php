<?php
/**
 * DEPLOY
 *
 * @package Deploy
 */

//  Connecting application
require __DIR__ . '/zero/class/App.php';
Zero_App::Init();

/**
 * КОНФИГУРАЦИЯ
 */
// ip адреса с которых разрешен деплой
$configIpAccess = [
    '158.255.1.134' => 1,
];
// ветка деплоя (репозитория инициатора)
$configBranch = 'master';
// папки репозиториев проекта для деплоя
$configDeploy = [
    ZERO_PATH_SITE,
    ZERO_PATH_ZERO,
];
//  пользователи которым разрешено производить деплой
$configUsers = [
    'konstantin@shamiev.ru' => 'Konstantin Shamiev',
];
//  ключевое слово (комментарий) инициирующее деплой
$configKeys = 'deploy';

/**
 * ИНИЦИАЛИЗАЦИЯ
 */
// Данные
if ( $_SERVER['REQUEST_METHOD'] === "PUT" )
{
    $data = file_get_contents('php://input', false, null, -1, $_SERVER['CONTENT_LENGTH']);
    $_REQUEST = json_decode($data, true);
}
else if ( $_SERVER['REQUEST_METHOD'] === "POST" && isset($GLOBALS["HTTP_RAW_POST_DATA"]) )
{
    $_REQUEST = json_decode($GLOBALS["HTTP_RAW_POST_DATA"], true);
}
else
{
    Zero_Logs::Set_Message_Error('request invalid');
    Zero_App::ResponseConsole();
}

Zero_Logs::File('request', $_REQUEST);

// IP access
if ( !isset($configIpAccess[$_SERVER['REMOTE_ADDR']]) )
{
    Zero_Logs::Set_Message_Error('access denied from IP: ' . $_SERVER['REMOTE_ADDR']);
    Zero_App::ResponseConsole();
}

// Ветка
if ( !isset($_REQUEST['ref']) )
{
    Zero_Logs::Set_Message_Error('ref invalid');
    Zero_App::ResponseConsole();
}
$branch = explode('/', $_REQUEST['ref'])[2];
if ( $configBranch != $branch )
{
    Zero_App::ResponseConsole();
}
//  Автор
if ( !isset($configUsers[$_REQUEST['commits'][0]['author']['email']]) )
{
    Zero_Logs::Set_Message_Error('deploy user access denied from: ' . $_REQUEST['commits'][0]['author']['email']);
    Zero_App::ResponseConsole();
}
//  Ключевое слово
if ( $_REQUEST['commits'][0]['message'] != $configKeys )
{
    Zero_Logs::Set_Message_Error('deploy key commit access denied');
    Zero_App::ResponseConsole();
}

/**
 * РАБОТА
 */
//  Выкладываем проект
foreach ($configDeploy as $path)
{
    exec("cd {$path} && git pull", $arr);
    Zero_Logs::File('deploy', $arr);
}
// Обнуляем логи
Zero_Helper_File::Folder_Move(ZERO_PATH_LOG, ZERO_PATH_LOG . date('Y-m-d-H'));
// Сбрасываем кеш
Zero_Helper_File::Folder_Remove(ZERO_PATH_CACHE);

/**
 * ЗАВЕРШЕНИЕ
 */
Zero_Logs::Set_Message_Notice('deploy successFull');
Zero_App::ResponseConsole();
exit;
