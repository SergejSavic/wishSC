<?php

namespace App\DTO\Product;

use App\DTO\AbstractDTO;

/**
 * Class WarehouseToShipping
 * @package App\DTO\Product
 */
class WarehouseToShipping extends AbstractDTO
{
    /**
     * @var ShippingDetails[]
     */
    private array $shippingDetails;
    /**
     * @var string
     */
    private string $warehouseId;

    /**
     * @return ShippingDetails[]
     */
    public function getShippingDetails(): array
    {
        return $this->shippingDetails;
    }

    /**
     * @param ShippingDetails[] $shippingDetails
     */
    public function setShippingDetails(array $shippingDetails): void
    {
        $this->shippingDetails = $shippingDetails;
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
            'shipping_details' => self::toBatch($this->shippingDetails),
            'warehouse_id' => $this->warehouseId
        ];
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): WarehouseToShipping
    {
        $warehouseToShipping = new self();
        $warehouseToShipping->warehouseId = self::getValue($data, 'warehouse_id');
        $warehouseToShipping->shippingDetails = ShippingDetails::fromBatch(self::getValue($data, 'shipping_details', []));

        return $warehouseToShipping;
    }
}
