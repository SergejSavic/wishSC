<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AutomaticCancellationServiceInterface;
use App\Contracts\Services\RefundReasonServiceInterface;
use App\Exceptions\RequestPayloadNotValid;
use App\Services\Business\Configuration\ConfigurationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use SendCloud\Infrastructure\Interfaces\Required\Configuration;

/**
 * Class ConfigurationController
 * @package App\Http\Controllers
 */
class ConfigurationController
{
    /**
     * @var ConfigurationService
     */
    private Configuration $configurationService;
    /**
     * @var RefundReasonServiceInterface
     */
    private RefundReasonServiceInterface $refundReasonService;
    /**
     * @var AutomaticCancellationServiceInterface
     */
    private AutomaticCancellationServiceInterface $automaticCancellationService;

    /**
     * ConfigurationController constructor.
     *
     * @param RefundReasonServiceInterface $refundReasonService
     * @param Configuration $configurationService
     * @param AutomaticCancellationServiceInterface $automaticCancellationService
     */
    public function __construct(
        RefundReasonServiceInterface $refundReasonService,
        Configuration $configurationService,
        AutomaticCancellationServiceInterface $automaticCancellationService
    )
    {
        $this->refundReasonService = $refundReasonService;
        $this->configurationService = $configurationService;
        $this->automaticCancellationService = $automaticCancellationService;
    }

    /**
     * Returns refund reason code if exists based on context
     *
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        $refundReasonCode = $this->refundReasonService->getRefundReason($this->configurationService->getContext());

        return response()->json([
            'refund' => $refundReasonCode,
            'automaticCancellation' =>
                $this->automaticCancellationService
                    ->isAutomaticCancellationEnabled($this->configurationService->getContext())
        ]);
    }

    /**
     * Save refund reason code for specific context
     *
     * @param Request $request
     * @return JsonResponse
     * @throws RequestPayloadNotValid
     */
    public function post(Request $request): JsonResponse
    {
        $this->verifyPayload($request);

        $this->refundReasonService->saveRefundReason(
            $request->get('refund'),
            $this->configurationService->getContext()
        );

        $this->automaticCancellationService->setAutomaticCancellation(
            filter_var($request->get('automaticCancellation'), FILTER_VALIDATE_BOOLEAN),
            $this->configurationService->getContext()
        );

        return response()->json([
            'refund' => $request->get('refund'),
            'automaticCancellation' => filter_var($request->get('automaticCancellation'), FILTER_VALIDATE_BOOLEAN)
        ]);
    }

    /**
     * Throws RequestPayloadNotValid if payload doesn't contain all information
     *
     * @param Request $request
     * @throws RequestPayloadNotValid
     */
    private function verifyPayload(Request $request): void
    {
        if (!$request->has('refund')) {
            throw new RequestPayloadNotValid('Credentials not valid.', 400);
        }
    }
}
