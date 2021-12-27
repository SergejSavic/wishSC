<?php

namespace App\Http\Controllers;

use App\Exceptions\RequestPayloadNotValid;
use App\Services\Business\Configuration\ConfigurationService;
use Illuminate\Http\Request;
use SendCloud\Infrastructure\Logger\Logger;
use Exception;
use RuntimeException;
use App\Exceptions\UnauthorizedException;
use SendCloud\Infrastructure\ServiceRegister;
use SendCloud\Infrastructure\Utility\GuidProvider;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class InitController
 * @package App\Http\Controllers
 */
class InitController extends BaseController
{
    private const DASHBOARD_ROUTE = 'sendcloud.welcome';

    /**
     * InitController constructor.
     * @param ConfigurationService $configService
     */
    public function __construct(ConfigurationService $configService)
    {
        parent::__construct($configService);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws UnauthorizedException
     */
    public function init(Request $request): Response
    {
        try {
            $this->verifyPayload($request);
            $this->configService->setContext($request->get('merchant_id'));
            $this->validateSendCloudParameters($request);
            $this->initializeApplication();

            return redirect()->route(
                self::DASHBOARD_ROUTE,
                [
                    'context' => $this->configService->getContext(),
                    'guid' => $this->configService->getGuid()
                ]
            );
        } catch (Exception $e) {
            Logger::logWarning('Connection failed! ' . $e->getMessage());
            throw new UnauthorizedException('Invalid credentials for Sendcloud user.', 401);
        }
    }

    /**
     * Validate SendCloud parameters
     *
     * @param Request $request
     * @return void
     * @throws UnauthorizedException
     */
    private function validateSendCloudParameters(Request $request): void
    {
        if ($request->get('public_key') !== $this->configService->getPublicKey() ||
            $request->get('secret_key') !== $this->configService->getSecretKey()) {

            Logger::logWarning('Sendcloud credentials are not valid.', 'Integration');
            throw new UnauthorizedException('Context not authorized!', 401);
        }
    }

    /**
     * Set guid for context
     */
    private function initializeApplication(): void
    {
        try {
            /** @var GuidProvider $guidProvider */
            $guidProvider = ServiceRegister::getService(GuidProvider::CLASS_NAME);

            $this->configService->setGuid(md5($guidProvider->generateGuid()));
        } catch (Exception $exception) {
            Logger::logWarning("An error during app initialization occurred: {$exception->getMessage()}", 'Integration');

            throw new RuntimeException('An error during app initialization occurred', 500);
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
        $expectedKeys = ['merchant_id', 'secret_key', 'public_key'];

        $this->verifyArrayKeys($expectedKeys, $request);
    }

    /**
     * Check if provided keys exists and not empty values for given array
     *
     * @param array $keys that should not be empty for given array
     * @param Request $request
     * @throws RequestPayloadNotValid
     */
    private function verifyArrayKeys(array $keys, Request $request): void
    {
        foreach ($keys as $key) {
            if (!$request->has($key)) {
                throw new RequestPayloadNotValid('Credentials not valid.', 400);
            }
        }
    }
}
