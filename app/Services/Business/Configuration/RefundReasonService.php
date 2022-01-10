<?php

namespace App\Services\Business\Configuration;

use App\Contracts\Services\RefundReasonServiceInterface;
use SendCloud\MiddlewareComponents\Models\Repository\ConfigRepository;

/**
 * Class RefundReasonService
 * @package App\Services\Business\Configuration
 */
class RefundReasonService implements RefundReasonServiceInterface
{
    /**
     * @var ConfigRepository
     */
    private ConfigRepository $configRepository;

    /**
     * ConfigurationService constructor.
     * @param ConfigRepository $configRepository
     */
    public function __construct(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;

    }

    /**
     * @inheritdoc
     */
    public function getRefundReason(?string $context): ?string
    {
        if ($context === null) {
            return null;
        }
        return $this->configRepository->getValue('REFUND_REASON', $context) ?: null;
    }

    /**
     * @inheritdoc
     */
    public function saveRefundReason(string $refundReasonCode, ?string $context): void
    {
        if ($context === null) {
            return;
        }
        $this->configRepository->saveValue('REFUND_REASON', $refundReasonCode, $context);
    }
}
