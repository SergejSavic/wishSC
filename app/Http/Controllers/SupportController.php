<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use SendCloud\BusinessLogic\Sync\InitialSyncTask;
use SendCloud\BusinessLogic\Sync\OrderSyncTask;
use SendCloud\BusinessLogic\Sync\ParcelUpdateTask;
use SendCloud\MiddlewareComponents\Controllers\Backend\SupportController as MiddlewareSupportController;
use SendCloud\Infrastructure\Interfaces\Exposed\TaskRunnerWakeup;
use SendCloud\Infrastructure\Interfaces\Required\Configuration;
use SendCloud\MiddlewareComponents\Models\QueueItem;
use SendCloud\Infrastructure\TaskExecution\QueueItem as SendcloudItem;

/**
 * Class SupportController
 * @package App\Http\Controllers
 */
class SupportController extends MiddlewareSupportController
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * SupportController constructor.
     *
     * @param Configuration $configService
     * @param TaskRunnerWakeup $wakeupService
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        Configuration $configService,
        TaskRunnerWakeup $wakeupService,
        UserRepositoryInterface $userRepository
    )
    {
        parent::__construct($configService, $wakeupService);
        $this->userRepository = $userRepository;
    }

    /**
     * Retrieves current information about integration.
     *
     * @return array
     */
    public function getSupportData(): array
    {
        $configData = parent::getSupportData();

        $configData['SENDCLOUD_WEBHOOK_TOKEN'] = $this->configService->getWebHookToken();
        $configData['WISH_TOTAL_USERS'] = $this->userRepository->getUsersCount();
        $configData['WISH_CONTEXTS'] = $this->userRepository->getAllContexts();

        if ($this->configService->getContext() !== null) {
            $user = $this->userRepository->getUser($this->configService->getContext());
            $configData['WISH_ACCESS_TOKEN'] = $user?->accessToken;
        }

        $configData['QUEUE_ITEMS'] = [
            'STATISTICS' => [
                'TOTAL' => [
                    'COMPLETED' => $this->countTasks(SendcloudItem::COMPLETED),
                    'IN_PROGRESS' => $this->countTasks(SendcloudItem::IN_PROGRESS),
                    'FAILED' => $this->countTasks(SendcloudItem::FAILED),
                    'QUEUED' => $this->countTasks(SendcloudItem::QUEUED),
                ],
                'initialSync' => [
                    'COMPLETED' => $this->count(SendcloudItem::COMPLETED, InitialSyncTask::getClassName()),
                    'IN_PROGRESS' => $this->count(SendcloudItem::IN_PROGRESS, InitialSyncTask::getClassName()),
                    'FAILED' => $this->count(SendcloudItem::FAILED, InitialSyncTask::getClassName()),
                    'QUEUED' => $this->count(SendcloudItem::QUEUED, InitialSyncTask::getClassName()),
                ],
                'orderSync' => [
                    'COMPLETED' => $this->count(SendcloudItem::COMPLETED, OrderSyncTask::getClassName()),
                    'IN_PROGRESS' => $this->count(SendcloudItem::IN_PROGRESS, OrderSyncTask::getClassName()),
                    'FAILED' => $this->count(SendcloudItem::FAILED, OrderSyncTask::getClassName()),
                    'QUEUED' => $this->count(SendcloudItem::QUEUED, OrderSyncTask::getClassName()),
                ],
                'parcelUpdate' => [
                    'COMPLETED' => $this->count(SendcloudItem::COMPLETED, ParcelUpdateTask::getClassName()),
                    'IN_PROGRESS' => $this->count(SendcloudItem::IN_PROGRESS, ParcelUpdateTask::getClassName()),
                    'FAILED' => $this->count(SendcloudItem::FAILED, ParcelUpdateTask::getClassName()),
                    'QUEUED' => $this->count(SendcloudItem::QUEUED, ParcelUpdateTask::getClassName()),
                ]
            ],
            'TASKS' => [
                'initialSync' => [
                    'COMPLETED' => $this->getTasks(SendcloudItem::COMPLETED, InitialSyncTask::getClassName()),
                    'IN_PROGRESS' => $this->getTasks(SendcloudItem::IN_PROGRESS, InitialSyncTask::getClassName()),
                    'FAILED' => $this->getTasks(SendcloudItem::FAILED, InitialSyncTask::getClassName()),
                    'QUEUED' => $this->getTasks(SendcloudItem::QUEUED, InitialSyncTask::getClassName()),
                ],
                'orderSync' => [
                    'COMPLETED' => $this->getTasks(SendcloudItem::COMPLETED, OrderSyncTask::getClassName()),
                    'IN_PROGRESS' => $this->getTasks(SendcloudItem::IN_PROGRESS, OrderSyncTask::getClassName()),
                    'FAILED' => $this->getTasks(SendcloudItem::FAILED, OrderSyncTask::getClassName()),
                    'QUEUED' => $this->getTasks(SendcloudItem::QUEUED, OrderSyncTask::getClassName()),
                ],
                'parcelUpdate' => [
                    'COMPLETED' => $this->getTasks(SendcloudItem::COMPLETED, ParcelUpdateTask::getClassName()),
                    'IN_PROGRESS' => $this->getTasks(SendcloudItem::IN_PROGRESS, ParcelUpdateTask::getClassName()),
                    'FAILED' => $this->getTasks(SendcloudItem::FAILED, ParcelUpdateTask::getClassName()),
                    'QUEUED' => $this->getTasks(SendcloudItem::QUEUED, ParcelUpdateTask::getClassName()),
                ]
            ],
        ];

        return $configData;
    }

    /**
     * @param string $status
     *
     * @return int
     */
    private function countTasks(string $status): int
    {
        return $this->getQuery($status)->count();
    }

    /**
     * @param string $status
     * @param string $type
     *
     * @return int
     */
    private function count(string $status, string $type): int
    {
        return $this->getQuery($status)
            ->where('type', $type)
            ->count();
    }

    /**
     * @param string $status
     *
     * @return Builder
     */
    private function getQuery(string $status): Builder
    {
        return QueueItem::where('context', $this->configService->getContext())
            ->where('status', $status);
    }

    /**
     * @param string $status
     * @param string $type
     *
     * @return Builder[]|Collection
     */
    private function getTasks(string $status, string $type): Collection|array
    {
        return $this->getQuery($status)
            ->where('type', $type)
            ->limit(20)
            ->orderBy('id', 'desc')
            ->get();
    }
}
