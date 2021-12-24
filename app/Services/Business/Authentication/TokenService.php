<?php

namespace App\Services\Business\Authentication;

use App\Contracts\Proxy\WishAuthProxyInterface;
use App\Contracts\Services\Auth\WishAuthServiceInterface;
use App\Contracts\Services\Auth\WishTokenServiceInterface;
use SendCloud\Infrastructure\Exceptions\InvalidConfigurationException;

class TokenService implements WishTokenServiceInterface
{
    const GRANT_TYPE = 'refresh_token';

    /**
     * @var WishAuthServiceInterface
     */
    protected WishAuthServiceInterface $authService;
    /**
     * @var WishAuthProxyInterface
     */
    private WishAuthProxyInterface $authProxy;

    /**
     * WishDocumentProxy constructor.
     * @param WishAuthServiceInterface $authService
     * @param WishAuthProxyInterface $authProxy
     */
    public function __construct(WishAuthServiceInterface $authService, WishAuthProxyInterface $authProxy)
    {
        $this->authService = $authService;
        $this->authProxy = $authProxy;
    }

    /**
     * Get valid access token
     *
     * @throws InvalidConfigurationException
     */
    public function getAccessToken(): string
    {
        if ($this->authService->getCurrentUser(true)->accessToken === null) {
            throw new InvalidConfigurationException('User not authorized', 'Integration');
        }

        $token = $this->authService->getCurrentUser()->accessToken;
        if (time() > $this->authService->getCurrentUser()->accessTokenExpiration) {
            $result = $this->authProxy->refreshToken($this->authService->getCurrentUser()->refreshToken, self::GRANT_TYPE);
            $this->authService->saveAuthData($result, $this->authService->getCurrentUser());
            $token = $result->getAccessToken();
        }

        if (empty($token)) {
            throw new InvalidConfigurationException('Access token missing');
        }

        return $token;
    }
}
