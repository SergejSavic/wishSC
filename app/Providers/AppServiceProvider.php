<?php

namespace App\Providers;

use App\Services\Business\Configuration\ConfigurationService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use SendCloud\Infrastructure\Interfaces\Required\Configuration;
use SendCloud\BusinessLogic\Interfaces\Proxy as SendCloudProxyInterface;
use SendCloud\Infrastructure\ServiceRegister;
use SendCloud\MiddlewareComponents\Sentry\Registrator;
use InvalidArgumentException;

/**
 * Class AppServiceProvider
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerServices();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $registrator = new Registrator();
        $registrator->register();

        try {
            URL::forceScheme('https');

            ServiceRegister::registerService(Configuration::class, static function () {
                return app(Configuration::class);
            });
            ServiceRegister::registerService(SendCloudProxyInterface::class, static function () {
                return app(SendCloudProxyInterface::class);
            });

        } catch (InvalidArgumentException $exception) {
            // Do nothing if service is already registered
        }
    }

    /**
     * Register services
     */
    protected function registerServices(): void
    {
        $this->app->singleton(Configuration::class, ConfigurationService::class);
    }
}
