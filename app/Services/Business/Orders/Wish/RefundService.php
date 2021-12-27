<?php

namespace App\Services\Business\Orders\Wish;

use App\Contracts\Proxy\WishProxyInterface;
use App\Contracts\Services\Orders\Wish\RefundServiceInterface;
use App\DTO\Refund\Refund;
use App\DTO\Sendcloud\Parcel;

/**
 * Class RefundService
 * @package App\Services\Business\Orders\Wish
 */
class RefundService implements RefundServiceInterface
{
    /**
     * @var WishProxyInterface
     */
    private WishProxyInterface $wishProxy;

    /**
     * ReturnService constructor.
     */
    public function __construct(WishProxyInterface $wishProxy)
    {
        $this->$wishProxy = $wishProxy;
    }

    /**
     * @param Parcel $parcel
     * @param string $refundReason
     * @return void
     */
    public function createRefund(Parcel $parcel, string $refundReason): void
    {
        $wishOrder = $this->wishProxy->getOrderById($parcel->getExternalOrderId());
        $refund =  new Refund();
        $refund->setRefundReason($refundReason);
        $refund->setRefundReasonNote('');

        $this->wishProxy->createRefund($refund, $wishOrder->getId());
    }
}
