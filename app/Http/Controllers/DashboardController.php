<?php

namespace App\Http\Controllers;

use App\Contracts\Proxy\WishProxyInterface;
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
    private const REFUND_REASON = 'UNABLE_TO_SHIP';

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
     */
    protected function getViewData(): array
    {
        $this->configService->setContext('6193d76bd02eee3b2c11c3ef');
        $data = parent::getViewData();
        $data['configuration_url'] = $this->getConfigurationControllerUrl();
        $data['is_service_points_enabled'] = false;
        $data['senderAddresses'] = $this->getSenderAddressViewData();
        $data['refundReason'] = self::REFUND_REASON;

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
    public function getSenderAddressViewData(): array
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
}
