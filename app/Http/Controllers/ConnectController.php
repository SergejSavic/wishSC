<?php

namespace App\Http\Controllers;

use App\Exceptions\RequestPayloadNotValid;
use App\SyncTasks\Sendcloud\IntegrationUpdateTask;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JsonException;
use SendCloud\BusinessLogic\Proxy;
use SendCloud\Infrastructure\Interfaces\Required\Configuration;
use SendCloud\Infrastructure\Logger\Logger;
use Exception;
use SendCloud\Infrastructure\Utility\Exceptions\HttpAuthenticationException;
use SendCloud\Infrastructure\Utility\Exceptions\HttpCommunicationException;
use SendCloud\Infrastructure\Utility\Exceptions\HttpRequestException;
use SendCloud\MiddlewareComponents\Utility\TaskQueue;

/**
 * Class ConnectController
 * @package App\Http\Controllers
 */
class ConnectController extends BaseController
{
    /**
     * @var Proxy
     */
    private Proxy $sendcloudProxy;

    /**
     * ConnectController constructor.
     *
     * @param Configuration $configService
     * @param Proxy $sendcloudProxy
     */
    public function __construct(
        Configuration $configService,
        Proxy         $sendcloudProxy
    )
    {
        parent::__construct($configService);
        $this->sendcloudProxy = $sendcloudProxy;
    }

    /**
     * Handles SendCloud connection action
     *
     * @param Request $request
     * @return JsonResponse|null
     */
    public function connect(Request $request): ?JsonResponse
    {
        try {
            $this->verifyPayload($request);
            $this->getSendcloudIntegrationCode($request);
            $this->setSendCloudAuthParameters($request);
            $this->initializeUserConnection();

            return response()->json($this->createResponseArray(true, 'Seller account is connected successfully.'));
        } catch (Exception $exception) {
            Logger::logWarning('Connection failed! ' . $exception->getMessage());
            return $this->getErrorResponse($exception);
        }
    }

    /**
     * @param Request $request
     * @return void
     * @throws HttpRequestException
     * @throws JsonException
     * @throws HttpCommunicationException
     */
    public function getSendcloudIntegrationCode(Request $request): void
    {
        try {
            $response = $this->sendcloudProxy->call(
                'GET',
                "integrations/{$request->get('integration_id')}",
                [],
                $request->get('public_key'),
                $request->get('secret_key')
            );

            $body = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            $integrationName = $body['system'] ?? null;

            if ($integrationName !== $this->configService->getIntegrationName()) {
                throw new HttpRequestException(__('Sendcloud credentials are not valid.'), 400);
            }

        } catch (HttpAuthenticationException|HttpRequestException $exception) {
            throw new HttpRequestException(__('Sendcloud credentials are not valid. Message: ' . $exception->getMessage()), 400);
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
        $expectedKeys = ['integration_id', 'secret_key', 'public_key', 'merchant_id'];

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

    /**
     * Stores SendCloud configuration parameters
     *
     * @param Request $request
     */
    private function setSendCloudAuthParameters(Request $request): void
    {
        $this->configService->setContext($request->get('merchant_id'));
        $this->configService->setIntegrationId($request->get('integration_id'));
        $this->configService->setPublicKey($request->get('public_key'));
        $this->configService->setSecretKey($request->get('secret_key'));
    }

    /**
     * Queues initial sync
     *
     */
    private function initializeUserConnection(): void
    {
        TaskQueue::enqueueContextSpecificTask(new IntegrationUpdateTask());
    }
}
