<?php

namespace Hillus\SinLaravelGraylog\Services;

use Gelf\Publisher;
use Gelf\Transport\UdpTransport;

class GraylogSetup
{
    public function getGelfPublisher() : Publisher
    {
        $transport = new UdpTransport(config('graylog.host'), config('graylog.port'),
            UdpTransport::CHUNK_SIZE_LAN);
        $publisher = new Publisher();
        $publisher->addTransport($transport);
        return $publisher;
    }
}