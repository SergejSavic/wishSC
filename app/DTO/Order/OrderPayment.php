<?php

namespace App\DTO\Order;

use App\DTO\AbstractDTO;

/**
 * Class OrderPayment
 * @package App\DTO\Order
 */
class OrderPayment extends AbstractDTO
{
    /**
     * @var GeneralPaymentDetails
     */
    private GeneralPaymentDetails $generalPaymentDetails;

    /**
     * @return GeneralPaymentDetails
     */
    public function getGeneralPaymentDetails(): GeneralPaymentDetails
    {
        return $this->generalPaymentDetails;
    }

    /**
     * @param GeneralPaymentDetails $generalPaymentDetails
     */
    public function setGeneralPaymentDetails(GeneralPaymentDetails $generalPaymentDetails): void
    {
        $this->generalPaymentDetails = $generalPaymentDetails;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'general_payment_details' => $this->generalPaymentDetails->toArray()
        ];
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): OrderPayment
    {
        $orderPayment = new self();
        $orderPayment->generalPaymentDetails = GeneralPaymentDetails::fromArray(self::getValue($data, 'general_payment_details', []));

        return $orderPayment;
    }
}
