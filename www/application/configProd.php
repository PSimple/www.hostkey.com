<?php
/**
 * The basic configuration of the all application.
 */
return [
    //  site settings
    'Site' => [
        //  The path to the php Interpreter (see command: whereis php)
        'PathPhp' => '/usr/bin/php',
        //  General Authorization Application
        'AccessLogin' => '',
        'AccessPassword' => '',
        //  Site name (of the project)
        'Name' => "Hostkey",
        //  Email the site (by default)
        'Email' => "support@hostkey.ru",
        //  Timeout online users status
        'UsersTimeoutOnline' => 600,
        //  Using a caching system
        'IsCache' => true,
        //  Parsing the templates view
        'TemplateParsing' => false,
        //  Language of the site by default
        'Language' => "en-en",
        //  Protocol
        'Protocol' => 'https',
        //  Domain of the site by default
        'Domain' => 'hostkey.com',
        //  Static Data Domain Site (css, js, img - design)
        'DomainAssets' => '',
        //  Domain binary data (uploaded by users)
        'DomainUpload' => '',
        // Use DB
        'UseDB' => true,
    ],
    //  Access for DB (Mysql)
    'Db' => [
        //  Profiling
        'main' => [
            'Host' => "localhost", //  Host or Socket
            'Login' => "root", //  User
            'Password' => "VohHe7io", //  Password
            'Name' => "site", //  Name DB
        ],
    ],
    //  Настройки почты
    'Mail' => [
        'Host' => 'ssl://smtp.gmail.com',
        //  Port
        'Port' => 465,
        //  Username
        'Username' => 'support@hostkey.ru',
        //  Password
        'Password' => 'sweetener@218_0',
        //  Retry count
        'RetryCnt' => 10,
        //  Api прямой отправки письма (если указан то используется он)
        'ApiSend' => '',
        //  Api отправки письма через очередь (если указан то используется он)
        'ApiQueue' => '',
        // Кодировка
        'CharSet' => 'utf-8',
    ],
    //  The settings of the presentation of data
    'View' => [
        //  Number of items per page
        'PageItem' => "20",
        //  The range of visible pages
        'PageStep' => "11",
    ],
    //  Monitoring
    'Log' => [
        //  Profiling
        'Profile' => [
            //  Fatal errors
            'Error' => true,
            //  Warning
            'Warning' => true,
            //  Notice
            'Notice' => true,
            //  User action
            'Action' => true,
            //  Work the application as a whole
            'Sql' => true,
            //  Work the application as a whole
            'Application' => true,
        ],
        //  Output
        'Output' => [
            //  File
            'File' => true,
            //  Display
            'Display' => false,
        ],
    ],
    //  Languages
    'Language' => [
        'en-en' => 'English',
        'ru-ru' => 'Русский',
    ],
    //  Servers Memcache
    'Memcache' => [
        //  For Cache data
        'Cache' => [
            //  'localhost:11211'
        ],
        //  Session storage
        'Session' => [
            //  'localhost:11211'
        ],
    ],
    //  роутинг Web запросов
    'Web' => [
    ],
    //  Ротуинг Api запросов
    'Api' => [
        new Shop_Config_Api(),
    ],
    //  Консольные задачи
    'Console' => [
        new Zero_Config_Console(),
        new Shop_Config_Console(),
    ],
];
