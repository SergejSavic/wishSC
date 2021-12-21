<?php

namespace App\Contracts\Repositories;

use App\DTO\AuthInfo\AuthInfo;
use App\Models\WishUser;

interface UserRepositoryInterface
{
    /**
     * Get user based on context
     *
     * @param ?string $context
     * @return WishUser|null
     */
    public function getUser(?string $context): ?WishUser;

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

    /**
     * Get total users count
     *
     * @return int
     */
    public function getUsersCount(): int;

    /**
     * Delete Wish user from database based on context
     *
     * @param string $context
     */
    public function deleteUserByContext(string $context): void;

    /**
     * Get all contexts
     *
     * @return mixed
     */
    public function getAllContexts(): array;
}

