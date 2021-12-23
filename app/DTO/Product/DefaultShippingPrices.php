<?php

namespace App\DTO\Product;

use App\DTO\AbstractDTO;

/**
 * Class DefaultShippingPrices
 * @package App\DTO\Product
 */
class DefaultShippingPrices extends AbstractDTO
{
    /**
     * @var DefaultShippingPrice
     */
    private DefaultShippingPrice $defaultShippingPrice;
    /**
     * @var string
     */
    private string $warehouseId;

    /**
     * @return DefaultShippingPrice
     */
    public function getDefaultShippingPrice(): DefaultShippingPrice
    {
        return $this->defaultShippingPrice;
    }

    /**
     * @param DefaultShippingPrice $defaultShippingPrice
     */
    public function setDefaultShippingPrice(DefaultShippingPrice $defaultShippingPrice): void
    {
        $this->defaultShippingPrice = $defaultShippingPrice;
    }

    /**
     * @return string
     */
    public function getWarehouseId(): string
    {
        return $this->warehouseId;
    }

    /**
     * @param string $warehouseId
     */
    public function setWarehouseId(string $warehouseId): void
    {
        $this->warehouseId = $warehouseId;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'default_shipping_price' => $this->defaultShippingPrice->toArray(),
            'warehouse_id' => $this->warehouseId
        ];
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): DefaultShippingPrices
    {
        $defaultShippingPrice = new self();
        $defaultShippingPrice->defaultShippingPrice = DefaultShippingPrice::fromArray(self::getValue($data, 'default_shipping_price', []));
        $defaultShippingPrice->warehouseId = self::getValue($data, 'warehouse_id');

        return $defaultShippingPrice;
    }
}
