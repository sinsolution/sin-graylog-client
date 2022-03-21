
        'graylog' => [
            'driver' => 'monolog',
            'handler' => Monolog\Handler\GelfHandler::class,
            'handler_with' => [
                'publisher' =>  app(Hillus\SinLaravelGraylog\Services\GraylogSetup::class)->getGelfPublisher(),
            ],
            // 'formatter' => \Monolog\Formatter\GelfMessageFormatter::class
            'formatter' => Hillus\SinLaravelGraylog\Log\GraylogMessageFormatter::class
        ],   