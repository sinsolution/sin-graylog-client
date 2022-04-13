<?php 

return [
    'host'   => env('GRAYLOG_HOST', '127.0.0.1'),
    'port'   => env('GRAYLOG_PORT', 4718),
    'mysql' => [
        'driver' => 'mysql',
        "host" => env('SINLOG_MYSQL_HOST','localhost'),
        "database" => env('SINLOG_MYSQL_DATABASE','applog'),
        "username" => env('SINLOG_MYSQL_USER','root'),
        "password" => env('SINLOG_MYSQL_PASSWORD','root'),
        "port" => env('SINLOG_MYSQL_PORT','3306'),
        "charset" => env('SINLOG_MYSQL_CHARSET','utf8'),
        "collation" => env('SINLOG_MYSQL_COLLATION','utf8_unicode_ci'),
        'prefix'    => '',
        'strict'    => false,
    ],
    'projeto_id' => env('SINLOG_PROJETO_ID',1),
];