<?php

namespace Hillus\SinLaravelGraylog\Tests;

use Illuminate\Support\Facades\Log;

class ClientTest extends TestCase
{
        /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        Log::channel('sinlog2')->info('testando log');
        $this->assertTrue(true);
    }

}