<?php

namespace Hillus\SinLaravelGraylog\Logging;

use Monolog\Logger;

class MySQLCustomLogger{
    
    /**
     * Create a custom Monolog instance.
     *
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    
    public function __invoke(array $config)
    {
        dump(__METHOD__);
        $logger = new Logger("MySQLLoggingHandler");
        return $logger->pushHandler(new MySQLLoggingHandler());
    }
}