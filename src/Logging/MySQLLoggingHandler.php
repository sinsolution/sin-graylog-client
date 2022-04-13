<?php

namespace Hillus\SinLaravelGraylog\Logging;

// use Illuminate\Log\Logger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

class MySQLLoggingHandler extends AbstractProcessingHandler
{/**
 *
 * Reference:
 * https://github.com/markhilton/monolog-mysql/blob/master/src/Logger/Monolog/Handler/MysqlHandler.php
 */
    public function __construct($level = Logger::DEBUG, $bubble = true) 
    {        
        $this->table = 'logs';
        parent::__construct($level, $bubble);
    }    
    
    protected function write(array $record):void
    {
       // dd($record);          
       $data = [
           'projeto_id'    => config('graylog.projeto_id'),
           'message'       => $record['message'],
           'context'       => json_encode($record['context']),
           'level'         => $record['level'],
           'level_name'    => $record['level_name'],
           'channel'       => $record['channel'],
           'record_datetime' => $record['datetime']->format('Y-m-d H:i:s'),
           'extra'         => json_encode($record['extra']),
           'formatted'     => $record['formatted'],
           'remote_addr'   => $_SERVER['REMOTE_ADDR'] ?? 'command',
           'user_agent'    => $_SERVER['HTTP_USER_AGENT'] ?? 'command',           
           'created_at'    => date("Y-m-d H:i:s"),
       ];
       
       $config = config('graylog.mysql');
       Config::set("database.connections.mysql_log", $config);

       DB::connection('mysql_log')->table($this->table)->insert($data);     
    }
}