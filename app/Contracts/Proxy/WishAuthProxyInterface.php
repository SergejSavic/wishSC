<?php

namespace App\Contracts\Proxy;

use App\DTO\AuthInfo\AuthInfo;

interface WishAuthProxyInterface
{
    /**
     * Get auth info from wish
     *
     * @param string $code
     * @param string $redirectUrl
     * @param string $grantType
     * @return AuthInfo
     */
    public function getAuthInfo(string $code, string $redirectUrl, string $grantType): AuthInfo;

    /**
     * Get auth info from wish
     *
     * @param string $refreshToken
     * @param string $grantType
     * @return AuthInfo
     */
    public function refreshToken(string $refreshToken, string $grantType): AuthInfo;
}