<?php

namespace App\Services\Business\Configuration;

use SendCloud\MiddlewareComponents\Services\Core\Business\ConfigurationService as MiddlewareConfigurationService;

/**
 * Class ConfigurationService
 * @package App\Services\Business\Configuration
 */
class ConfigurationService extends MiddlewareConfigurationService
{
    protected const INTEGRATION_NAME = 'wish';
    private const DEFAULT_PANEL_URL = 'https://panel.sendcloud.sc/';

    /**
     * @inheritdoc
     */
    public function getBaseUrl(): string
    {
        $baseUrl = config('app.url');

        return rtrim($baseUrl, '/') . '/';
    }

    /**
     * @inheritdoc
     */
    public function getShopName(): string
    {
        if (!empty($this->getContext())) {
            return static::INTEGRATION_NAME . ' - ' . $this->getContext();
        }

        return self::INTEGRATION_NAME;
    }

    /**
     * @inheritdoc
     */
    public function getIntegrationName(): string
    {
        return self::INTEGRATION_NAME;
    }

    /**
     * @inheritdoc
     */
    public function getQueueName(): string
    {
        $prefix = !empty($this->getContext()) ? $this->getContext() : '';

        return substr($prefix . '-' . $this->getIntegrationName(), 0, 50);
    }

    /**
     * @inheritDoc
     */
    public function getSendCloudPanelUrl(): string
    {
        if (!$panelUrl = config('services.sendcloud.panel_url')) {
            $panelUrl = self::DEFAULT_PANEL_URL;
        }

        return rtrim($panelUrl, '/') . '/';
    }

    /**
     * Gets integration code
     *
     * @return string|null
     */
    public function getIntegrationCode(): ?string
    {
        return $this->configRepository->getValue('SENDCLOUD_INTEGRATION_CODE', $this->getContext());
    }

    /**
     * Sets integration code
     *
     * @param string $integrationCode
     */
    public function setIntegrationCode(string $integrationCode): void
    {
        $this->configRepository->saveValue('SENDCLOUD_INTEGRATION_CODE', $integrationCode, $this->getContext());
    }

    /**
     * @inheritdoc
     */
    public function isServicePointEnabled(): bool
    {
        return false;
    }
}
