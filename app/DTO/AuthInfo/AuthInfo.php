<?php

namespace App\DTO\AuthInfo;

use App\DTO\AbstractDTO;

/**
 * Class AuthInfo
 * @package App\DTO\AuthInfo
 */
class AuthInfo extends AbstractDTO
{
    /**
     * @var string
     */
    private string $merchantId;
    /**
     * @var string
     */
    private string $accessToken;
    /**
     * @var string
     */
    private string $refreshToken;
    /**
     * @var string
     */
    private string $accessTokenExpiration;

    /**
     * @return string
     */
    public function getMerchantId(): string
    {
        return $this->merchantId;
    }

    /**
     * @param string $merchantId
     */
    public function setMerchantId(string $merchantId): void
    {
        $this->merchantId = $merchantId;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    /**
     * @param string $refreshToken
     */
    public function setRefreshToken(string $refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }

    /**
     * @return string
     */
    public function getAccessTokenExpiration(): string
    {
        return $this->accessTokenExpiration;
    }

    /**
     * @param string $accessTokenExpiration
     */
    public function setAccessTokenExpiration(string $accessTokenExpiration): void
    {
        $this->accessTokenExpiration = $accessTokenExpiration;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): AuthInfo
    {
        $authInfo = new self();
        $authInfo->merchantId = self::getValue($data, 'merchant_id');
        $authInfo->accessToken = self::getValue($data, 'access_token');
        $authInfo->refreshToken = self::getValue($data, 'refresh_token');
        $authInfo->accessTokenExpiration = self::getValue($data, 'expiry_time');

        return $authInfo;
    }
}
