<?php
namespace Hillus\SinLaravelGraylog;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @throws \Exception
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__.'/../config/graylog.php';
        $this->mergeConfigFrom($configPath, 'graylog');

       
        // $this->app->alias('singraylog', SinApi::class);

        $this->app->singleton('singraylog', function ($app) {
            return new \Hillus\SinLaravelGraylog\Service\GraylogSetup($app['config'], $app['files']);
        });

    }

    /**
     * Check if package is running under Lumen app
     *
     * @return bool
     */
    protected function isLumen()
    {
        return Str::contains($this->app->version(), 'Lumen') === true;
    }

    public function boot()
    {
        if (! $this->isLumen()) {
            $configPath = __DIR__.'/../config/graylog.php';
            $this->publishes([$configPath => config_path('graylog.php')], 'config');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('singraylog');
    }

}