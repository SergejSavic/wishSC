<?php

namespace App\DTO\Product;

use App\DTO\AbstractDTO;

/**
 * Class ShippingDetails
 * @package App\DTO\Product
 */
class ShippingDetails extends AbstractDTO
{
    /**
     * @var bool
     */
    private bool $isEnabled;
    /**
     * @var string
     */
    private string $destination;
    /**
     * @var Price
     */
    private Price $price;

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    /**
     * @param bool $isEnabled
     */
    public function setIsEnabled(bool $isEnabled): void
    {
        $this->isEnabled = $isEnabled;
    }

    /**
     * @return string
     */
    public function getDestination(): string
    {
        return $this->destination;
    }

    /**
     * @param string $destination
     */
    public function setDestination(string $destination): void
    {
        $this->destination = $destination;
    }

    /**
     * @return Price
     */
    public function getPrice(): Price
    {
        return $this->price;
    }

    /**
     * @param Price $price
     */
    public function setPrice(Price $price): void
    {
        $this->price = $price;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'is_enabled' => $this->isEnabled,
            'destination' => $this->destination,
            'price' => $this->price->toArray()
        ];
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): ShippingDetails
    {
        $shippingDetails = new self();
        $shippingDetails->isEnabled = self::getValue($data, 'is_enabled');
        $shippingDetails->destination = self::getValue($data, 'destination');
        $shippingDetails->price = Price::fromArray(self::getValue($data, 'price', []));

        return $shippingDetails;
    }
}
