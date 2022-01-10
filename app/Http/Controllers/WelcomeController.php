<?php

namespace App\Http\Controllers;

use App\Contracts\Services\Auth\WishAuthServiceInterface;
use SendCloud\Infrastructure\Interfaces\Required\Configuration;
use SendCloud\MiddlewareComponents\Controllers\Backend\WelcomeController as MiddlewareWelcomeController;

/**
 * Class WelcomeController
 * @package App\Http\Controllers
 */
class WelcomeController extends MiddlewareWelcomeController
{
    /**
     * @var WishAuthServiceInterface
     */
    private WishAuthServiceInterface $authService;

    /**
     * DashboardController constructor.
     */
    public function __construct(Configuration $configService, WishAuthServiceInterface $authService)
    {
        parent::__construct($configService);
        $this->authService = $authService;
    }

    /**
     * @inheritDoc
     * @return array
     */
    protected function getViewData(): array
    {
        $data['auth_url'] = $this->authService->getAuthBaseUrl() .
            'authorize?client_id=' . config('services.wish.client_id') .
            '&state=' . $this->configService->getContext();

        return $data;
    }
}
