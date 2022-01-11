<?php

namespace App\Http\Controllers;

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
     * ConfigurationController constructor.
     *
     * @param RefundReasonServiceInterface $refundReasonService
     * @param Configuration $configurationService
     */
    public function __construct(
        RefundReasonServiceInterface $refundReasonService,
        Configuration $configurationService,
    )
    {
        $this->refundReasonService = $refundReasonService;
        $this->configurationService = $configurationService;
    }

    /**
     * Returns warehouse mapping, shipment type, country, hs code, automatic cancellation and refund reason code if exists based on context
     *
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        $returnReason = $this->refundReasonService->getReturnReason($this->configurationService->getContext());
        $automaticReturn = $this->configurationService->isAutomaticReturnEnabled($this->configurationService->getContext());
        $warehouseMapping = $this->configurationService->getWarehouseMapping();
        $shipmentType = $this->configurationService->getShipmentType();
        $country = $this->configurationService->getCountry();
        $hsCode = $this->configurationService->getHsCode();

        return response()->json([
            'return' => $returnReason,
            'automaticReturn' => $automaticReturn,
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
            'return' => $request->get('return'),
            'automaticReturn' => filter_var($request->get('automaticReturn'), FILTER_VALIDATE_BOOLEAN),
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
        $expectedKeys = ['warehouses', 'shipmentType', 'country', 'hsCode', 'return', 'automaticReturn'];

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

        $this->refundReasonService->saveReturnReason(
            $request->get('return'),
            $context
        );

        $this->configurationService->setAutomaticReturn(
            filter_var($request->get('automaticReturn'), FILTER_VALIDATE_BOOLEAN),
            $context
        );

        $this->configurationService->setWarehouseMapping($request->get('warehouses'), $context);
        $this->configurationService->setShipmentType($request->get('shipmentType'), $context);
        $this->configurationService->setCountry($request->get('country'), $context);
        $this->configurationService->setHsCode($request->get('hsCode'), $context);
    }
}
