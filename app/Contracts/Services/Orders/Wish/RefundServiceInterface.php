<?php

namespace App\Contracts\Services\Orders\Wish;

use App\DTO\Sendcloud\Parcel;

interface RefundServiceInterface
{
    /**
     * Create refund for Wish
     *
     * @param Parcel $parcel
     * @param string $refundReason
     * @param string $refundReasonNote
     */
    public function createRefund(Parcel $parcel, string $refundReason, string $refundReasonNote):void;
}
