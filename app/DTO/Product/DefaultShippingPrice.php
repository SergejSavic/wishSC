<?php

namespace App\DTO\Product;

use App\DTO\AbstractDTO;

/**
 * Class DefaultShippingPrice
 * @package App\DTO\Product
 */
class DefaultShippingPrice extends AbstractDTO
{
    /**
     * @var int
     */
    private int $amount;
    /**
     * @var string
     */
    private string $currencyCode;

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
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
    public static function fromArray(array $data): DefaultShippingPrice
    {
        $defaultShippingPrice = new self();
        $defaultShippingPrice->amount = self::getValue($data, 'amount');
        $defaultShippingPrice->currencyCode = self::getValue($data, 'currency_code');

        return $defaultShippingPrice;
    }
}
