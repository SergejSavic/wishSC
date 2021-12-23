<?php

namespace App\DTO\Order;

use App\DTO\AbstractDTO;

/**
 * Class ProductShippingPrice
 * @package App\DTO\Order
 */
class ProductShippingPrice extends AbstractDTO
{
    /**
     * @var float
     */
    private float $amount;
    /**
     * @var string
     */
    private string $currencyCode;

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    /**
     * @param string $currencyCode
     */
    public function setCurrencyCode(string $currencyCode): void
    {
        $this->currencyCode = $currencyCode;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'currency_code' => $this->currencyCode
        ];
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): ProductShippingPrice
    {
        $productShippingPrice = new self();
        $productShippingPrice->amount = self::getValue($data, 'amount');
        $productShippingPrice->currencyCode = self::getValue($data, 'currency_code');

        return $productShippingPrice;
    }
}
