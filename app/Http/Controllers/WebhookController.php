<?php

namespace App\Http\Controllers;

use App\Exceptions\RequestPayloadNotValid;
use JsonException;
use SendCloud\BusinessLogic\Sync\OrderCancelTask;
use SendCloud\BusinessLogic\Sync\OrderSyncTask;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use SendCloud\MiddlewareComponents\Utility\TaskQueue;

/**
 * Class WebhookController
 * @package App\Http\Controllers
 */
class WebhookController
{
    private const ORDER_RELEASE = 'ORDER_RELEASE';
    private const ORDER_REFUND = 'ORDER_REFUND';
    private const ORDER_ADDRESS_CHANGE = 'ORDER_ADDRESS_CHANGE';

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws RequestPayloadNotValid
     * @throws JsonException
     */
    public function handle(Request $request): JsonResponse
    {
        $response = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR)[0];

        $idValidator = Validator::make($response, [
            'entity_id' => 'required'
        ]);

        if ($idValidator->fails() || !$request->header('Wish-Topic')) {
            throw new RequestPayloadNotValid('Credentials not valid.', 400);
        }

        $action = $request->header('Wish-Topic');
        $entityId = $response['entity_id'];
        switch ($action) {
            case self::ORDER_ADDRESS_CHANGE:
            case self::ORDER_RELEASE:
                $success = $this->handleOrderRelease($entityId);

                break;
            case self::ORDER_REFUND:
                $success = $this->handleOrderRefund($entityId);

                break;
            default:
                $success = true;
        }

        return response()->json(['success' => $success]);
    }

    /**
     * Handles order release action
     *
     * @param string $orderId
     * @return bool
     */
    private function handleOrderRelease(string $orderId): bool
    {
        TaskQueue::enqueueContextSpecificTask(new OrderSyncTask([$orderId => $orderId]));

        return true;
    }

    /**
     * Handles order release action
     *
     * @param string $orderId
     * @return bool
     */
    private function handleOrderRefund(string $orderId): bool
    {
        TaskQueue::enqueueContextSpecificTask(new OrderCancelTask($orderId));

        return true;
    }
}
