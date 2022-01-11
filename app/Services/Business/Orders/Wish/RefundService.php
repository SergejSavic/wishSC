<?php

namespace App\Services\Business\Orders\Wish;

use App\Contracts\Proxy\WishProxyInterface;
use App\Contracts\Services\Orders\Wish\RefundServiceInterface;
use App\DTO\Refund\Refund;
use App\DTO\Sendcloud\Parcel;
use Exception;

/**
 * Class RefundService
 * @package App\Services\Business\Tracking\Wish
 */
class RefundService implements RefundServiceInterface
{
    /**
     * @var WishProxyInterface
     */
    private WishProxyInterface $wishProxy;

    /**
     * ShipmentService constructor.
     */
    public function __construct(WishProxyInterface $wishProxy)
    {
        $this->wishProxy = $wishProxy;
    }

    /**
     * @param Parcel $parcel
     * @param string $refundReason
     * @param string $refundReasonNote
     * @return void
     * @throws Exception
     */
    public function createRefund(Parcel $parcel, string $refundReason, string $refundReasonNote): void
    {
        $wishOrder = $this->wishProxy->getOrderById($parcel->getExternalOrderId());
        $refund = new Refund();
        $refund->setRefundReason($refundReason);
        $refund->setRefundReasonNote($refundReasonNote);

        if ($wishOrder !== null) {
            $this->wishProxy->createRefund($refund, $wishOrder->getId());
        } else {
            throw new Exception('Order is null', 400);
        }
    }
}
