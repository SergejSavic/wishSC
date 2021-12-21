<?php

namespace App\SyncTasks\Sendcloud;

use SendCloud\BusinessLogic\Sync\BaseSyncTask;
use SendCloud\Infrastructure\Utility\Exceptions\HttpAuthenticationException;
use SendCloud\Infrastructure\Utility\Exceptions\HttpCommunicationException;
use SendCloud\Infrastructure\Utility\Exceptions\HttpRequestException;

class IntegrationUpdateTask extends BaseSyncTask
{
    /**
     * @inheritDoc
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     */
    public function execute(): void
    {
        $integrationId = $this->getConfigService()->getIntegrationId();

        $integration = $this->getProxy()->getIntegrationById($integrationId);
        $this->reportProgress(50);

        $integration->setWebHookUrl($this->getConfigService()->getWebHookEndpoint(true));
        $integration->setWebHookActive(true);

        $this->getProxy()->updateIntegration($integration);

        $this->reportProgress(100);
    }
}
