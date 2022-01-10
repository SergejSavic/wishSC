<?php

namespace App\Http\Controllers;

use App\Services\Business\Router\RouterService;
use Illuminate\Http\RedirectResponse;
use SendCloud\BusinessLogic\Sync\InitialSyncTask;
use SendCloud\Infrastructure\TaskExecution\Exceptions\QueueStorageUnavailableException;
use SendCloud\MiddlewareComponents\Controllers\Backend\InitialSyncController as MiddlewareInitialSyncController;

/**
 * Class InitialSyncController
 * @package App\Http\Controllers
 */
class InitialSyncController extends MiddlewareInitialSyncController
{
    private const DASHBOARD_ROUTE = 'dashboard';

    /**
     * Enqueues initial sync task.
     *
     * @return RedirectResponse
     *
     * @throws QueueStorageUnavailableException
     */
    public function index(): RedirectResponse
    {
        $this->queue->enqueue(
            $this->configService->getQueueName(),
            new InitialSyncTask(),
            $this->configService->getContext()
        );

        return redirect(RouterService::getRedirectUrl(
            self::DASHBOARD_ROUTE,
            [
                'context' => $this->configService->getContext(),
                'guid' => $this->configService->getGuid()
            ])
        );
    }
}
