<?php

namespace App\DTO\Refund;

use App\DTO\AbstractDTO;

/**
 * Class Refund
 * @package App\DTO\Refund
 */
class Refund extends AbstractDTO
{
    /**
     * @var string
     */
    private string $refundReason;
    /**
     * @var string
     */
    private string $refundReasonNote;

    /**
     * @return string
     */
    public function getRefundReason(): string
    {
        return $this->refundReason;
    }

    /**
     * @param string $refundReason
     */
    public function setRefundReason(string $refundReason): void
    {
        $this->refundReason = $refundReason;
    }

    /**
     * @return string
     */
    public function getRefundReasonNote(): string
    {
        return $this->refundReasonNote;
    }

    /**
     * @param string $refundReasonNote
     */
    public function setRefundReasonNote(string $refundReasonNote): void
    {
        $this->refundReasonNote = $refundReasonNote;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'refund_reason' => $this->refundReason,
            'refund_reason_note' => $this->refundReasonNote
        ];
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): AbstractDTO
    {
        $refund = new self();
        $refund->refundReason = self::getValue($data, 'refund_reason');
        $refund->refundReasonNote = self::getValue($data, 'refund_reason_note');

        return $refund;
    }
}
