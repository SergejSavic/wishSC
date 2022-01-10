<?php

namespace App\Contracts\Services;

interface RefundReasonServiceInterface
{
    /**
     * Get refund reason code
     *
     * @param string|null $context
     * @return string|null
     */
    public function getRefundReason(?string $context): ?string;

    /**
     * Save refund reason for specific context
     *
     * @param string $refundReasonCode
     * @param string|null $context
     */
    public function saveRefundReason(string $refundReasonCode, ?string $context): void;
    /**
     * Get cancel reason code
     *
     * @param string|null $context
     * @return string|null
     */
    public function getCancelReason(?string $context): ?string;

    /**
     * Save cancel reason for specific context
     *
     * @param string $cancelReasonCode
     * @param string|null $context
     */
    public function saveCancelReason(string $cancelReasonCode, ?string $context): void;
}
