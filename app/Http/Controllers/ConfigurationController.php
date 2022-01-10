<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AutomaticCancellationServiceInterface;
use App\Contracts\Services\RefundReasonServiceInterface;
use App\Exceptions\RequestPayloadNotValid;
use App\Exceptions\UnauthorizedException;
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
     * Returns warehouse mapping, shipment type, country, hs code, automatic cancellation and refund reason code if exists based on context
     *
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        $cancelReasonCode = $this->refundReasonService->getCancelReason($this->configurationService->getContext());
        $automaticCancellation = $this->automaticCancellationService->isAutomaticCancellationEnabled($this->configurationService->getContext());
        $warehouseMapping = $this->configurationService->getWarehouseMapping();
        $shipmentType = $this->configurationService->getShipmentType();
        $country = $this->configurationService->getCountry();
        $hsCode = $this->configurationService->getHsCode();

        return response()->json([
            'cancel' => $cancelReasonCode,
            'automaticCancellation' => $automaticCancellation,
            'warehouses' => $warehouseMapping,
            'shipmentType' => $shipmentType,
            'country' => $country,
            'hsCode' => $hsCode
        ]);
    }

    /**
     * Verifies request and saves values
     *
     * @param Request $request
     * @return JsonResponse
     * @throws RequestPayloadNotValid
     * @throws UnauthorizedException
     */
    public function post(Request $request): JsonResponse
    {
        $this->verifyPayload($request);
        $this->saveValues($request, $this->configurationService->getContext());

        return response()->json([
            'cancel' => $request->get('cancel'),
            'automaticCancellation' => filter_var($request->get('automaticCancellation'), FILTER_VALIDATE_BOOLEAN),
            'shipmentType' => $request->get('shipmentType'),
            'warehouses' => $request->get('warehouses'),
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
        $expectedKeys = ['warehouses', 'shipmentType', 'country', 'hsCode', 'cancel', 'automaticCancellation'];

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
     * Saves warehouse mapping, shipment type, country, hs code, automatic cancellation and refund reason code if context exists
     *
     * @param Request $request
     * @param string|null $context
     * @return void
     * @throws UnauthorizedException
     */
    private function saveValues(Request $request, ?string $context): void
    {
        if ($context === null) {
            return;
        }

        $this->refundReasonService->saveCancelReason(
            $request->get('cancel'),
            $context
        );

        $this->automaticCancellationService->setAutomaticCancellation(
            filter_var($request->get('automaticCancellation'), FILTER_VALIDATE_BOOLEAN),
            $context
        );

        $this->configurationService->setWarehouseMapping($request->get('warehouses'), $context);
        $this->configurationService->setShipmentType($request->get('shipmentType'), $context);
        $this->configurationService->setCountry($request->get('country'), $context);
        $this->configurationService->setHsCode($request->get('hsCode'), $context);
    }
}
