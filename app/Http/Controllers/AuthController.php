<?php

namespace App\Http\Controllers;

use App\Contracts\Proxy\WishAuthProxyInterface;
use App\DTO\AuthInfo\AuthInfo;
use App\Exceptions\RequestPayloadNotValid;
use App\Services\Business\Authentication\AuthService;
use App\Services\Business\Configuration\ConfigurationService;
use App\Services\Business\Orders\Sendcloud\OrderService;
use SendCloud\Infrastructure\Logger\Logger;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\UnauthorizedException;
use Exception;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends BaseController
{
    private const DASHBOARD_ROUTE = 'sendcloud.dashboard';
    private const GRANT_TYPE = 'authorization_code';

    /**
     * @var WishAuthProxyInterface
     */
    private WishAuthProxyInterface $authProxy;

    /**
     * @var AuthService
     */
    private AuthService $authService;
    private OrderService $orderService;

    /**
     * InitController constructor.
     * @param ConfigurationService $configService
     * @param WishAuthProxyInterface $authProxy
     * @param AuthService $authService
     */
    public function __construct(
        ConfigurationService $configService,
        WishAuthProxyInterface $authProxy,
        AuthService $authService,
        OrderService $orderService
    )
    {
        parent::__construct($configService);
        $this->authProxy = $authProxy;
        $this->authService = $authService;
        $this->orderService = $orderService;
    }

    /**
     * Handle callback request from Wish during authorization process
     */
    public function index(Request $request): Response
    {
        try {
            $this->verifyPayload($request);
            $authInfo = $this->getAuthInfo($request);

            if ($user = $this->authService->getCurrentUser()) {
                $this->authService->saveAuthData($authInfo, $user);
            } else {
                $this->authService->createNewUser($authInfo, $this->configService->getContext());
            }

            return redirect()->route(
                self::DASHBOARD_ROUTE,
                [
                    'context' => $this->configService->getContext(),
                    'guid' => $this->configService->getGuid()
                ]
            );
        } catch (Exception $e) {
            Logger::logWarning('Wish authorization failed! ' . $e->getMessage());
            return response()->view('errors.401', ['exception' => $e]);
        }
    }

    /**
     * Throws RequestPayloadNotValid if payload doesn't contain all information
     *
     * @param Request $request
     * @throws RequestPayloadNotValid
     */
    private function verifyPayload(Request $request): void
    {
        if (!$request->has('code')) {
            throw new RequestPayloadNotValid('Credentials not valid.', 400);
        }
        $this->configService->setContext($request->get('merchant_id'));

        $publicKey = $this->configService->getPublicKey();
        $secretKey = $this->configService->getSecretKey();

        if (empty($publicKey) || empty($secretKey)) {
            throw new RequestPayloadNotValid('Credentials not valid. Public and secret key are not set for this context', 400);
        }
    }

    /**
     * Get auth info
     *
     * @param Request $request
     * @return AuthInfo
     * @throws UnauthorizedException
     */
    private function getAuthInfo(Request $request): AuthInfo
    {
        try {
            return $this->authProxy->getAuthInfo($request->get('code'), 'https://oauth.pstmn.io/v1/callback', self::GRANT_TYPE);

        } catch (Exception $e) {
            Logger::logWarning('Incorrect authorization code!', 'Integration');

            throw new UnauthorizedException('Incorrect authorization code!', 401);
        }
    }
}
