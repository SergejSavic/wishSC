<?php

namespace App\Services\Business\Configuration;

use App\Exceptions\UnauthorizedException;
use JsonException;
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
     * @inheritdoc
     */
    public function isServicePointEnabled(): bool
    {
        return false;
    }

    /**
     * Gets one time token - guid
     *
     * @return string|null
     */
    public function getGuid(): ?string
    {
        return $this->configRepository->getValue('WISH_GUID', $this->getContext());
    }

    /**
     * Sets guid
     *
     * @param string $guid
     */
    public function setGuid(string $guid): void
    {
        $this->configRepository->saveValue('WISH_GUID', $guid, $this->getContext());
    }

    /**
     * Gets shipment type
     *
     * @return string|null
     */
    public function getShipmentType(): ?string
    {
        return $this->configRepository->getValue('SHIPMENT_TYPE', $this->getContext());
    }

    /**
     * Sets shipment type
     *
     * @param string $shipmentType
     * @param string|null $context
     * @throws UnauthorizedException
     */
    public function setShipmentType(string $shipmentType, ?string $context): void
    {
        if (empty($context)) {
            throw new UnauthorizedException();
        }

        $this->configRepository->saveValue('SHIPMENT_TYPE', $shipmentType, $this->getContext());
    }

    /**
     * Gets country
     *
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->configRepository->getValue('COUNTRY', $this->getContext());
    }

    /**
     * Sets country
     *
     * @param string $country
     * @param string|null $context
     * @throws UnauthorizedException
     */
    public function setCountry(string $country, ?string $context): void
    {
        if (empty($context)) {
            throw new UnauthorizedException();
        }

        $this->configRepository->saveValue('COUNTRY', $country, $this->getContext());
    }

    /**
     * Gets hs code
     *
     * @return string|null
     */
    public function getHsCode(): ?string
    {
        return $this->configRepository->getValue('HS_CODE', $this->getContext());
    }

    /**
     * Sets hs code
     *
     * @param string $hsCode
     * @param string|null $context
     * @throws UnauthorizedException
     */
    public function setHsCode(string $hsCode, ?string $context): void
    {
        if (empty($context)) {
            throw new UnauthorizedException();
        }

        $this->configRepository->saveValue('HS_CODE', $hsCode, $this->getContext());
    }

    /**
     * @return string|null
     */
    public function getWarehouseMapping(): ?string
    {
        return $this->configRepository->getValue('WAREHOUSE_MAPPING', $this->getContext());
    }

    /**
     * @param string $mapping
     * @param string|null $context
     * @return void
     * @throws UnauthorizedException
     */
    public function setWarehouseMapping(string $mapping, ?string $context): void
    {
        if (empty($context)) {
            throw new UnauthorizedException();
        }

        $this->configRepository->saveValue('WAREHOUSE_MAPPING', $mapping, $this->getContext());
    }
}
