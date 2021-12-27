<?php

namespace App\Services\Business\Configuration;

use App\Contracts\Services\AutomaticCancellationServiceInterface;
use SendCloud\MiddlewareComponents\Models\Repository\ConfigRepository;

/**
 * Class AutomaticCancellationService
 * @package App\Services\Business\Configuration
 */
class AutomaticCancellationService implements AutomaticCancellationServiceInterface
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
    public function isAutomaticCancellationEnabled(?string $context): bool
    {
        if ($context === null) {
            return false;
        }
        return $this->configRepository->getValue('AUTOMATIC_CANCELLATION', $context) ?: false;
    }

    /**
     * @inheritdoc
     */
    public function setAutomaticCancellation(bool $automaticCancellation, ?string $context): void
    {
        if ($context === null) {
            return;
        }
        $this->configRepository->saveValue('AUTOMATIC_CANCELLATION', $automaticCancellation, $context);
    }
}
