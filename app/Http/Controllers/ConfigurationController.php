<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AutomaticCancellationServiceInterface;
use App\Contracts\Services\RefundReasonServiceInterface;
use App\Exceptions\RequestPayloadNotValid;
use App\Services\Business\Configuration\ConfigurationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use SendCloud\Infrastructure\Interfaces\Required\Configuration;
use SendCloud\MiddlewareComponents\Models\Repository\ConfigRepository;

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
     * Returns sender address, shipment type, country, hs code, automatic cancellation and refund reason code if exists based on context
     *
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        $refundReasonCode = $this->refundReasonService->getRefundReason($this->configurationService->getContext());
        $automaticCancellation = $this->automaticCancellationService->isAutomaticCancellationEnabled($this->configurationService->getContext());
        $senderAddress = $this->configurationService->getSenderAddress();
        $shipmentType = $this->configurationService->getShipmentType();
        $country = $this->configurationService->getCountry();
        $hsCode = $this->configurationService->getHsCode();

        return response()->json([
            'refund' => $refundReasonCode,
            'automaticCancellation' => $automaticCancellation,
            'senderAddress' => $senderAddress,
            'shipmentType' => $shipmentType,
            'country' => $country,
            'hsCode' => $hsCode
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
        $this->saveValues($request, $this->configurationService->getContext());

        return response()->json([
            'refund' => $request->get('refund'),
            'automaticCancellation' => filter_var($request->get('automaticCancellation'), FILTER_VALIDATE_BOOLEAN),
            'senderAddress' => $request->get('senderAddress'),
            'shipmentType' => $request->get('shipmentType'),
            'country' => $request->get('country'),
            'hsCode' => $request->get('hsCode')
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
        $expectedKeys = ['senderAddress', 'shipmentType', 'country', 'hsCode', 'refund', 'automaticCancellation'];

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
     * Saves sender address, shipment type, country, hs code, automatic cancellation and refund reason code if context exists
     *
     * @param Request $request
     * @param string|null $context
     * @return void
     */
    private function saveValues(Request $request, ?string $context): void
    {
        if ($context === null) {
            return;
        }

        $this->refundReasonService->saveRefundReason(
            $request->get('refund'),
            $context
        );

        $this->automaticCancellationService->setAutomaticCancellation(
            filter_var($request->get('automaticCancellation'), FILTER_VALIDATE_BOOLEAN),
            $context
        );

        $this->configurationService->setSenderAddress($request->get('senderAddress'));
        $this->configurationService->setShipmentType($request->get('shipmentType'));
        $this->configurationService->setCountry($request->get('country'));
        $this->configurationService->setHsCode($request->get('hsCode'));
    }
}
