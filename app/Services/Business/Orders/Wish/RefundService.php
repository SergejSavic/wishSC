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
    private const REFUND_REASON_NOTE = 'Parcel canceled';

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
     * @return void
     * @throws Exception
     */
    public function createRefund(Parcel $parcel, string $refundReason): void
    {
        $wishOrder = $this->wishProxy->getOrderById($parcel->getExternalOrderId());
        $refund = new Refund();
        $refund->setRefundReason($refundReason);
        $refund->setRefundReasonNote(self::REFUND_REASON_NOTE);

        if ($wishOrder !== null) {
            $this->wishProxy->createRefund($refund, $wishOrder->getId());
        } else {
            throw new Exception('Order is null', 400);
        }
    }
}
