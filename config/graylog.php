<?php 

return [
    'host'   => env('GRAYLOG_HOST', '127.0.0.1'),
    'port'   => env('GRAYLOG_PORT', 4718),
    'mysql' => [
        "host" => env('SINLOG_MYSQL_HOST','localhost'),
        "database" => env('SINLOG_MYSQL_DATABASE','applog'),
        "username" => env('SINLOG_MYSQL_USER','root'),
        "password" => env('SINLOG_MYSQL_PASSWORD','root')
    ],
];