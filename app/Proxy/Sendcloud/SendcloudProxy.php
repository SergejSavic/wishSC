<?php

namespace App\Proxy\Sendcloud;

use App\DTO\Sendcloud\Parcel;
use App\DTO\Sendcloud\SenderAddress;
use JsonException;
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
     * @return SenderAddress[]|null
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws JsonException
     */
    public function getSenderAddresses(): ?array
    {
        $response = $this->call('GET', 'user/addresses/sender');
        $response = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        return isset($response['sender_addresses']) ? SenderAddress::fromBatch($response['sender_addresses']) : [];
    }
}
