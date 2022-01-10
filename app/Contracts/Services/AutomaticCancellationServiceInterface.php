<?php

namespace App\Contracts\Services;

/**
 * Interface AutomaticCancellationServiceInterface
 * @package App\Contracts\Services
 */
interface AutomaticCancellationServiceInterface
{
    /**
     * Get is automatic cancellation enabled
     *
     * @param string|null $context
     * @return bool
     */
    public function isAutomaticCancellationEnabled(?string $context): bool;

    /**
     * Save automatic cancellation configuration
     *
     * @param bool $automaticCancellation
     * @param string|null $context
     */
    public function setAutomaticCancellation(bool $automaticCancellation, ?string $context): void;
}
