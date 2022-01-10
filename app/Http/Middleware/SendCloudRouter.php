<?php

namespace App\Http\Middleware;

use App\Contracts\Services\Auth\WishAuthServiceInterface;
use App\Services\Business\Router\RouterService;
use Closure;
use Illuminate\Http\Request;
use SendCloud\BusinessLogic\Interfaces\ConnectService;
use SendCloud\Infrastructure\Interfaces\Required\Configuration;
use SendCloud\Infrastructure\TaskExecution\Queue;
use SendCloud\Infrastructure\Utility\Exceptions\HttpRequestException;
use SendCloud\MiddlewareComponents\Middleware\SendCloudRouter as MiddlewareSendCloudRouter;

/**
 * Class SendCloudRouter
 * @package App\Http\Middleware
 */
class SendCloudRouter extends MiddlewareSendCloudRouter
{
    /**
     * @var Configuration
     */
    private Configuration $configService;

    /**
     * @var WishAuthServiceInterface
     */
    private WishAuthServiceInterface $wishAuthService;

    /**
     * SendCloudRouter constructor.
     *
     * @param ConnectService $connectService
     * @param Queue $queue
     * @param Configuration $configService
     * @param WishAuthServiceInterface $miraklAuthService
     */
    public function __construct(ConnectService $connectService, Queue $queue, Configuration $configService, WishAuthServiceInterface $miraklAuthService)
    {
        parent::__construct($connectService, $queue);
        $this->configService = $configService;
        $this->wishAuthService = $miraklAuthService;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     * @throws HttpRequestException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $this->request = $request;
        $this->validateRequest();
        $currentAction = $this->getAction();

        if (!$this->isUserAuthenticated()) {
            $permittedAction = self::WELCOME;
        } elseif (!$this->isInitialSyncEnqueued()) {
            $permittedAction = self::SYNC;
        } else {
            $permittedAction = self::DASHBOARD;
        }

        if ($currentAction !== $permittedAction) {
            if ($permittedAction === self::SYNC) {
                return redirect()->route($permittedAction, $this->getAdditionalParameters());
            }
            $route = substr($permittedAction, strpos($permittedAction, ".") + 1);

            return redirect(RouterService::getRedirectUrl($route, $this->getAdditionalParameters()));
        }

        return $next($this->request);
    }

    /**
     * @inheritDoc
     * @throws HttpRequestException
     */
    protected function validateRequest(): void
    {
        parent::validateRequest();
        $this->configService->setContext($this->request->get('context'));

        if (!$this->request->has('guid') || ($this->request->get('guid') !== $this->configService->getGuid())) {
            throw new HttpRequestException('Missing or invalid guid', 400);
        }
    }

    /**
     * @inheritDoc
     * @return array
     */
    protected function getAdditionalParameters(): array
    {
        $additionalParameters = parent::getAdditionalParameters();
        $additionalParameters['guid'] = $this->configService->getGuid();

        return $additionalParameters;
    }

    /**
     * Check if user is authenticated
     *
     * @return bool
     */
    private function isUserAuthenticated(): bool
    {
        return !($this->wishAuthService->getCurrentUser() === null ||
            $this->wishAuthService->getCurrentUser()->accessToken === null);
    }
}
