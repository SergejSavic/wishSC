<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\DTO\AuthInfo\AuthInfo;
use App\Models\WishUser;
use DateInterval;
use DateTime;
use Exception;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function getUser(?string $context): ?WishUser
    {
        if ($context === null) {
            return null;
        }
        return WishUser::where('context', $context)->get()->first();
    }

    /**
     * @inheritdoc
     */
    public function createNewUser(AuthInfo $result, string $context): void
    {
        $user = new WishUser();

        $user->context = $context;
        $this->saveAuthData($result, $user);
    }

    /**
     * @inheritdoc
     */
    public function saveAuthData(AuthInfo $result, WishUser $user): void
    {
        $user->accessToken = $result->getAccessToken();
        $user->refreshToken = $result->getRefreshToken();
        $user->merchantId = $result->getMerchantId();

        $user->save();
    }

    /**
     * @inheritdoc
     */
    public function getUsersCount(): int
    {
        return WishUser::query()->count();
    }

    /**
     * @inheritdoc
     */
    public function deleteUserByContext(string $context): void
    {
        WishUser::query()->where('context', $context)->delete();
    }

    /**
     * @inheritdoc
     */
    public function getAllContexts(): array
    {
        return WishUser::all('context')->pluck('context')->toArray() ?? [];
    }
}
