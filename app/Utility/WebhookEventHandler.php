<?php

namespace App\Utility;

use App\Contracts\Repositories\UserRepositoryInterface;
use Exception;
use SendCloud\BusinessLogic\DTO\WebhookDTO;
use SendCloud\BusinessLogic\Interfaces\ConnectService;
use SendCloud\Infrastructure\ServiceRegister;
use SendCloud\MiddlewareComponents\Models\Repository\ConfigRepository;
use SendCloud\Infrastructure\Logger\Logger;
use SendCloud\MiddlewareComponents\Models\Repository\QueueItemRepository;
use SendCloud\MiddlewareComponents\Utility\WebhookEventHandler as MiddlewareWebhookEventHandler;

/**
 * Class WebhookEventHandler
 * @package App\Utility
 */
class WebhookEventHandler extends MiddlewareWebhookEventHandler
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * WebhookEventHandler constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Removes user data, queue and config record for the specified context
     *
     * @param WebhookDTO $webhookDTO
     *
     * @return bool
     */
    protected function handleIntegrationDelete(WebhookDTO $webhookDTO): bool
    {
        try {
            QueueItemRepository::delete($webhookDTO->getContext());
            ConfigRepository::delete($webhookDTO->getContext());
            $this->userRepository->deleteUserByContext($webhookDTO->getContext());
        } catch (Exception $exception) {
            Logger::logWarning("Error occurred while handling integration delete action. " . $exception->getMessage(), 'Integration');
            return false;
        }

        return parent::handleIntegrationDelete($webhookDTO);
    }

    /**
     * Check if webhook payload is valid
     *
     * @param WebhookDTO $webhookDTO
     *
     * @return bool
     * @see https://docs.sendcloud.sc/api/v2/shipping/#integration-connected
     */
    protected function handleIntegrationCredentials(WebhookDTO $webhookDTO): bool
    {
        try {
            /** @var ConnectService $connectService */
            $connectService = ServiceRegister::getService(ConnectService::CLASS_NAME);
            $credentials = $this->getWebhookHelper()->parseIntegrationCredentials($webhookDTO->getBody());
            $success = $connectService->isCallbackValid($credentials, $webhookDTO->getToken());
        } catch (Exception $e) {
            Logger::logWarning("Error occurred while checking webhook payload validation. " . $e->getMessage(), 'Integration');
            $this->getConfiguration()->setContext($webhookDTO->getContext());
            $this->getConfiguration()->resetAuthorizationCredentials();
            $success = false;
        }

        return $success;
    }
}
