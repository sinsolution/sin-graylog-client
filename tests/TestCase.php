<?php

namespace Hillus\SinLaravelGraylog\Tests;

use Hillus\SinLaravelGraylog\Facade;
use Hillus\SinLaravelGraylog\ServiceProvider;
use Illuminate\Support\Facades\View;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();

        // View::addLocation(__DIR__.'/views');
    }

    /**
     * Define environment setup.
     *
     * @param  Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('logging.channels.stack.channels',['sinlog', 'single']);
        $app['config']->set('logging.channels.sinlog',[
            'driver' => 'custom',
            'handler' => Hillus\SinLaravelGraylog\Logging\MySQLLoggingHandler::class,
            'via' => Hillus\SinLaravelGraylog\Logging\MySQLCustomLogger::class,
            'level' => 'debug',
        ]);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return string[]
     */
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return string[]
     */
    protected function getPackageAliases($app)
    {
        return [
            'SinTicketingClient' => Facade::class,
        ];
    }
}