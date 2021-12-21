<?php

namespace App\Contracts\Services\Auth;

use App\DTO\AuthInfo\AuthInfo;
use App\Models\WishUser;

interface WishAuthServiceInterface
{
    /**
     * Get current user
     *
     * @return WishUser|null
     */
    public function getCurrentUser(bool $forceLoad = false): ?WishUser;

    /**
     * Set current user
     *
     * @param WishUser $wishUser
     */
    public function setCurrentUser(WishUser $wishUser): void;

    /**
     * Gets api base url
     *
     * @return string
     */
    public function getApiBaseUrl(): string;

    /**
     * Get auth url
     *
     * @return string
     */
    public function getAuthBaseUrl(): string;

    /**
     * Creates a new Wish user
     *
     * @param AuthInfo $result
     * @param string $context
     */
    public function createNewUser(AuthInfo $result, string $context): void;

    /**
     * Save auth info for wish user
     *
     * @param AuthInfo $result
     * @param WishUser $user
     */
    public function saveAuthData(AuthInfo $result, WishUser $user): void;
}
