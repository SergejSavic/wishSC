<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\DTO\AuthInfo\AuthInfo;
use App\Models\WishUser;
use DateInterval;
use DateTime;
use Exception;
use SendCloud\MiddlewareComponents\Models\QueueItem;
use SendCloud\MiddlewareComponents\Models\Repository\QueueItemRepository;

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

        return $this->getUsersCount() > 0 ? WishUser::where('context', $context)->get()->first() : null;
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
        $user->accessTokenExpiration = $result->getAccessTokenExpiration();

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

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function getInactiveContexts(): array
    {
        $currentTime = new DateTime('@' . time());
        $earliestValidTime = $currentTime->sub(new DateInterval('P120D'));

        return QueueItem::query()->where('lastUpdateTimestamp', '<', $earliestValidTime->getTimestamp())
            ->pluck('context')
            ->toArray();
    }
}
