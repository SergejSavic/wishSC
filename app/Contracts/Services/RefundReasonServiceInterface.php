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
    public function getReturnReason(?string $context): ?string;

    /**
     * Save refund reason for specific context
     *
     * @param string $refundReasonCode
     * @param string|null $context
     */
    public function saveReturnReason(string $refundReasonCode, ?string $context): void;

    /**
     * Get cancellation reason code
     *
     * @param string|null $context
     * @return string|null
     */
    public function getCancellationReason(?string $context): ?string;

    /**
     * Save cancellation reason for specific context
     *
     * @param string $cancelReasonCode
     * @param string|null $context
     */
    public function saveCancellationReason(string $cancelReasonCode, ?string $context): void;
}
