<?php

namespace App\Http\Controllers;

use App\Contracts\Orders\Countries\CountryCodesInterface;
use App\Contracts\Orders\Shipment\ShipmentTypesInterface;
use App\Contracts\Proxy\WishProxyInterface;
use App\DTO\Warehouse\Warehouse;
use App\Proxy\Sendcloud\SendcloudProxy;
use JsonException;
use SendCloud\BusinessLogic\Interfaces\Proxy;
use SendCloud\Infrastructure\Interfaces\Required\Configuration;
use SendCloud\Infrastructure\ServiceRegister;
use SendCloud\Infrastructure\Utility\Exceptions\HttpAuthenticationException;
use SendCloud\Infrastructure\Utility\Exceptions\HttpCommunicationException;
use SendCloud\Infrastructure\Utility\Exceptions\HttpRequestException;
use SendCloud\MiddlewareComponents\Controllers\Backend\DashboardController as MiddlewareDashboardController;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends MiddlewareDashboardController
{
    private const ITEM_RETURNED_TO_SENDER = 'ITEM_RETURNED_TO_SENDER';
    private const ITEM_IS_DAMAGED = 'ITEM_IS_DAMAGED';
    private const UNABLE_TO_SHIP = 'UNABLE_TO_SHIP';

    /**
     * @var WishProxyInterface
     */
    private WishProxyInterface $wishProxy;

    /**
     * DashboardController constructor.
     */
    public function __construct(Configuration $configService, WishProxyInterface $wishProxy)
    {
        parent::__construct($configService);
        $this->wishProxy = $wishProxy;
    }

    /**
     * @inheritDoc
     * @return array
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws JsonException
     */
    protected function getViewData(): array
    {
        $data = parent::getViewData();
        $data['configuration_url'] = $this->getConfigurationControllerUrl();
        $data['is_service_points_enabled'] = true;
        $data['senderAddresses'] = $this->getSenderAddressViewData();
        $data['countries'] = $this->getCountries();
        $data['shipmentTypes'] = $this->getShipmentTypes();
        $data['returnReasons'] = $this->getRefundReasons();
        $data['warehouses'] = $this->getWarehouses();

        return $data;
    }

    /**
     * Returns configuration controller url
     *
     * @return string
     */
    private function getConfigurationControllerUrl(): string
    {
        if (config('app.debug')) {
            return config('app.url') .
                route(
                    'api.v1.configuration.save',
                    [
                        'context' => $this->configService->getContext(),
                        'guid' => $this->configService->getGuid(),
                        'XDEBUG_SESSION_START' => 'debug',
                    ],
                    false
                );
        }

        return route(
            'api.v1.configuration.save',
            [
                'context' => $this->configService->getContext(),
                'guid' => $this->configService->getGuid(),
            ]
        );
    }

    /**
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws HttpAuthenticationException
     * @throws JsonException
     */
    private function getSenderAddressViewData(): array
    {
        /** @var SendCloudProxy $sendCloudProxy */
        $sendCloudProxy = ServiceRegister::getService(Proxy::CLASS_NAME);
        $senderAddresses = $sendCloudProxy->getSenderAddresses();
        $data = [];
        foreach ($senderAddresses as $senderAddress) {
            $data[] = [
                'value' => $senderAddress->getId(),
                'label' => $senderAddress->getCompanyName() . ', ' . $senderAddress->getStreet() . ' ' .
                    $senderAddress->getHouseNumber() . ', ' . $senderAddress->getPostalCode() . ' ' .
                    $senderAddress->getCity() . ', ' . $senderAddress->getCountry()
            ];
        }

        return $data;
    }

    /**
     * @return array
     */
    private function getCountries(): array
    {
        $data = [];
        foreach (CountryCodesInterface::CODES as $name => $iso2) {
            $data[] = [
                'value' => $iso2,
                'label' => $name
            ];
        }

        return $data;
    }

    /**
     * @return array
     */
    private function getShipmentTypes(): array
    {
        $data = [];
        foreach (ShipmentTypesInterface::SHIPMENT_TYPES as $shipmentType) {
            $data[] = [
                'value' => $shipmentType['value'],
                'label' => $shipmentType['label']
            ];
        }

        return $data;
    }

    /**
     * @return string[]
     */
    public function getRefundReasons(): array
    {
        $cancellationReasons = [self::ITEM_IS_DAMAGED, self::ITEM_RETURNED_TO_SENDER];
        $data = [];

        foreach ($cancellationReasons as $reason) {
            $data[] = [
                'value' => $reason,
                'label' => str_replace('_', ' ', $reason)
            ];
        }

        return $data;
    }

    /**
     * @return Warehouse[]|null
     */
    private function getWarehouses(): ?array
    {
        return $this->wishProxy->getWarehouses();
    }
}
