<?php

namespace App\Proxy;

use App\Contracts\Proxy\WishAuthProxyInterface;
use App\DTO\AuthInfo\AuthInfo;
use JsonException;
use SendCloud\Infrastructure\Utility\Exceptions\HttpCommunicationException;
use SendCloud\Infrastructure\Utility\Exceptions\HttpRequestException;

/**
 * Class AuthProxy
 * @package App\Proxy
 */
class AuthProxy extends BaseProxy implements WishAuthProxyInterface
{
    /**
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws JsonException
     */
    public function getAuthInfo(string $code, string $redirectUrl, string $grantType): AuthInfo
    {
        $response = $this->get('/oauth/access_token', $this->getBody($grantType, '', $code, $redirectUrl));

        return AuthInfo::fromArray($response['data']);
    }

    /**
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws JsonException
     */
    public function refreshToken(string $refreshToken, string $grantType): AuthInfo
    {
        $response = $this->get('/oauth/refresh_token', $this->getBody($grantType, $refreshToken));

        return AuthInfo::fromArray($response['data']);
    }

    /**
     * Get body based on grant type
     *
     * @param string $grantType
     * @param string $refreshToken
     * @param string $code
     * @param string $redirectUrl
     * @return array
     */
    private function getBody(string $grantType, string $refreshToken = '', string $code = '', string $redirectUrl = ''): array
    {
        if ($grantType === 'authorization_code') {
            return [
                'client_id' => config('services.wish.client_id'),
                'client_secret' => config('services.wish.client_secret'),
                'code' => $code,
                'grant_type' => $grantType,
                'redirect_uri' => $redirectUrl
            ];
        }
        return [
            'client_id' => config('services.wish.client_id'),
            'client_secret' => config('services.wish.client_secret'),
            'refresh_token' => $refreshToken,
            'grant_type' => $grantType
        ];
    }
}
