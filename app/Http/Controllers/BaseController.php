<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use SendCloud\Infrastructure\Interfaces\Required\Configuration;
use SendCloud\MiddlewareComponents\Services\Core\Business\ConfigurationService;

/**
 * Class BaseController
 * @package App\Http\Controllers
 */
class BaseController
{
    /**
     * @var ConfigurationService
     */
    protected $configService;

    /**
     * BaseController constructor.
     *
     * @param Configuration $configService implementation of Configuration interface
     */
    public function __construct(Configuration $configService)
    {
        $this->configService = $configService;
    }

    /**
     * Return error response in json format
     * {
     *   "success":true/false,
     *   "message":errorMessage
     * }
     *
     * @param Exception $exception for extracting message and error code
     *
     * @return JsonResponse|null
     */
    protected function getErrorResponse(Exception $exception): ?JsonResponse
    {
        $errorCode = !empty($exception->getCode()) ? $exception->getCode() : 400;

        return response()->json($this->createResponseArray(false, $exception->getMessage()), $errorCode);
    }

    /**
     * Creates response data
     *
     * @param bool $success is request successful
     * @param string $message for response
     *
     * @return array
     */
    protected function createResponseArray(bool $success, string $message): array
    {
        return [
            'success' => $success,
            'message' => $message,
        ];
    }
}
