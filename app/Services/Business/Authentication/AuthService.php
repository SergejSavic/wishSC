<?php

namespace App\Services\Business\Authentication;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\Auth\WishAuthServiceInterface;
use App\DTO\AuthInfo\AuthInfo;
use App\Models\WishUser;
use SendCloud\Infrastructure\Interfaces\Required\Configuration;

/**
 * Class AuthService
 * @package App\Services\Business\Authentication
 */
class AuthService implements WishAuthServiceInterface
{

    /**
     * @var WishUser|null
     */
    private ?WishUser $currentUser = null;

    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * @var Configuration
     */
    private Configuration $configService;


    /**
     * AuthService constructor.
     *
     * @param UserRepositoryInterface $userRepository
     * @param Configuration $configService
     */
    public function __construct(UserRepositoryInterface $userRepository, Configuration $configService)
    {
        $this->userRepository = $userRepository;
        $this->configService = $configService;
    }

    /**
     * @inheritdoc
     */
    public function getCurrentUser(bool $forceLoad = false): ?WishUser
    {
        if ($this->currentUser === null || $forceLoad) {
            $this->currentUser = $this->userRepository->getUser($this->configService->getContext());
        }

        return $this->currentUser;
    }

    /**
     * @inheritdoc
     */
    public function setCurrentUser(WishUser $wishUser): void
    {
        $this->currentUser = $wishUser;
    }

    public function getApiBaseUrl(): string
    {
        return config("services.wish.api_url") . '/';
    }

    /**
     * @inheritdoc
     */
    public function getAuthBaseUrl(): string
    {
        return config("services.wish.auth_url") . '/';
    }

    /**
     * @inheritdoc
     */
    public function createNewUser(AuthInfo $result, string $context): void
    {
        $this->userRepository->createNewUser($result, $context);
    }

    /**
     * @inheritdoc
     */
    public function saveAuthData(AuthInfo $result, WishUser $user): void
    {
        $this->userRepository->saveAuthData($result, $user);
    }
}
