<?php

namespace App\Proxy\Sendcloud;

use App\DTO\Sendcloud\Parcel;
use App\DTO\Sendcloud\SenderAddress;
use SendCloud\BusinessLogic\Proxy;
use SendCloud\Infrastructure\Utility\Exceptions\HttpAuthenticationException;
use SendCloud\Infrastructure\Utility\Exceptions\HttpCommunicationException;
use SendCloud\Infrastructure\Utility\Exceptions\HttpRequestException;

/**
 * Class SendcloudProxy
 * @package App\Proxy\Sendcloud
 */
class SendcloudProxy extends Proxy
{
    /**
     * Returns parcel by order number
     *
     * @param string $orderNumber
     *
     * @return Parcel|null
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     */
    public function getParcelByOrderNumber(string $orderNumber): ?Parcel
    {
        $response = json_decode(
            $this->call('GET', "parcels?order_number=$orderNumber")->getBody(),
            true);

        return !empty($response['parcels']) ? Parcel::fromArray($response['parcels'][0]) : null;
    }

    /**
     * @return SenderAddress[]|null
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     */
    public function getSenderAddresses(): ?array
    {
        $response = json_decode(
            $this->call('GET', "user/addresses/sender")->getBody(),
            true);

        return !empty($response['sender_addresses']) ? SenderAddress::fromBatch($response['sender_addresses']) : null;
    }
}
