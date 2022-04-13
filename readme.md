
        'graylog' => [
            'driver' => 'monolog',
            'handler' => Monolog\Handler\GelfHandler::class,
            'handler_with' => [
                'publisher' =>  app(Hillus\SinLaravelGraylog\Services\GraylogSetup::class)->getGelfPublisher(),
            ],
            // 'formatter' => \Monolog\Formatter\GelfMessageFormatter::class
            'formatter' => Hillus\SinLaravelGraylog\Log\GraylogMessageFormatter::class
        ], 


    ## Log Mysql 

    Usando como base o artigo de custom log em mysql
    https://alucard001.medium.com/laravel-6-custom-logging-to-mysql-database-step-by-step-hand-holding-50e07bdcbb65
    

    Edite o arquivo config/logging.php e adicione o código abaixo no array
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['sinlog', 'single'], // aqui vamos pegar além do log normal o stack de error
            'ignore_exceptions' => false,
        ],
        /////////////////////////////////////////////////
        ///// Just look at below// Log to MySQL
        'sinlog' => [
            'driver' => 'custom',
            'handler' => Hillus\SinLaravelGraylog\Logging\MySQLLoggingHandler::class,
            'via' => Hillus\SinLaravelGraylog\Logging\MySQLCustomLogger::class,
            'level' => 'debug',
        ],

        ////// Just look at above
        /////////////////////////////////////////////////  