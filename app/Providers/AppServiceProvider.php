<?php

namespace App\Providers;

use App\Contracts\Proxy\WishAuthProxyInterface;
use App\Contracts\Proxy\WishProxyInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\Auth\WishAuthServiceInterface;
use App\Contracts\Services\Auth\WishTokenServiceInterface;
use App\Contracts\Services\AutomaticCancellationServiceInterface;
use App\Contracts\Services\Orders\Wish\RefundServiceInterface;
use App\Contracts\Services\Orders\Wish\ShipmentServiceInterface;
use App\Contracts\Services\RefundReasonServiceInterface;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WelcomeController;
use App\Proxy\AuthProxy;
use App\Proxy\Sendcloud\SendcloudProxy;
use App\Proxy\WishProxy;
use App\Http\Controllers\InitialSyncController;
use SendCloud\MiddlewareComponents\Controllers\Backend\InitialSyncController as MiddlewareInitialSyncController;
use App\Repositories\UserRepository;
use App\Services\Business\Authentication\AuthService;
use App\Services\Business\Authentication\TokenService;
use App\Services\Business\Configuration\AutomaticCancellationService;
use App\Services\Business\Configuration\ConfigurationService;
use App\Services\Business\Configuration\RefundReasonService;
use App\Services\Business\Orders\Sendcloud\OrderService;
use App\Services\Business\Orders\Wish\RefundService;
use App\Services\Business\Orders\Wish\ShipmentService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use SendCloud\BusinessLogic\Interfaces\OrderService as OrderServiceInterface;
use SendCloud\Infrastructure\Interfaces\Required\Configuration;
use SendCloud\BusinessLogic\Interfaces\Proxy as SendCloudProxyInterface;
use SendCloud\MiddlewareComponents\Controllers\Backend\WelcomeController as MiddlewareWelcomeController;
use SendCloud\MiddlewareComponents\Controllers\Backend\DashboardController as MiddlewareDashboardController;
use SendCloud\Infrastructure\ServiceRegister;
use SendCloud\MiddlewareComponents\Sentry\Registrator;
use App\Utility\WebhookEventHandler;
use SendCloud\MiddlewareComponents\Utility\WebhookEventHandler as MiddlewareWebhookEventHandler;
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
        $this->registerProxies();
        $this->registerRepositories();
        $this->overrideMiddlewareClasses();
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
            URL::forceScheme('http');

            ServiceRegister::registerService(Configuration::class, static function () {
                return app(Configuration::class);
            });
            ServiceRegister::registerService(SendCloudProxyInterface::class, static function () {
                return app(SendCloudProxyInterface::class);
            });
            ServiceRegister::registerService(OrderServiceInterface::class, static function () {
                return app(OrderServiceInterface::class);
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
        $this->app->singleton(WishAuthServiceInterface::class, AuthService::class);
        $this->app->singleton(WishTokenServiceInterface::class, TokenService::class);
        $this->app->singleton(OrderServiceInterface::class, OrderService::class);
        $this->app->singleton(ShipmentServiceInterface::class, ShipmentService::class);
        $this->app->singleton(RefundServiceInterface::class, RefundService::class);
        $this->app->singleton(RefundReasonServiceInterface::class, RefundReasonService::class);
        $this->app->singleton(AutomaticCancellationServiceInterface::class, AutomaticCancellationService::class);
    }

    /**
     * Register proxies
     */
    protected function registerProxies(): void
    {
        $this->app->singleton(WishAuthProxyInterface::class, AuthProxy::class);
        $this->app->singleton(WishProxyInterface::class, WishProxy::class);
        $this->app->singleton(SendCloudProxyInterface::class, SendcloudProxy::class);
    }

    /**
     * Register repositories
     */
    protected function registerRepositories(): void
    {
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Overrides classes implemented in middleware components
     */
    protected function overrideMiddlewareClasses(): void
    {
        $this->app->bind(MiddlewareWebhookEventHandler::class, WebhookEventHandler::class);
        $this->app->bind(MiddlewareWelcomeController::class, WelcomeController::class);
        $this->app->bind(MiddlewareDashboardController::class, DashboardController::class);
        $this->app->bind(MiddlewareInitialSyncController::class, InitialSyncController::class);
    }
}
