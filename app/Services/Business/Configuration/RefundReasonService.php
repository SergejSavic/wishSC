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
    public function getReturnReason(?string $context): ?string
    {
        if ($context === null) {
            return null;
        }
        return $this->configRepository->getValue('RETURN_REASON', $context) ?: null;
    }

    /**
     * @inheritdoc
     */
    public function saveReturnReason(string $refundReasonCode, ?string $context): void
    {
        if ($context === null) {
            return;
        }
        $this->configRepository->saveValue('RETURN_REASON', $refundReasonCode, $context);
    }

    /**
     * @inheritdoc
     */
    public function getCancellationReason(?string $context): ?string
    {
        if ($context === null) {
            return null;
        }
        return $this->configRepository->getValue('CANCEL_REASON', $context) ?: null;
    }

    /**
     * @inheritdoc
     */
    public function saveCancellationReason(string $cancelReasonCode, ?string $context): void
    {
        if ($context === null) {
            return;
        }
        $this->configRepository->saveValue('CANCEL_REASON', $cancelReasonCode, $context);
    }
}
