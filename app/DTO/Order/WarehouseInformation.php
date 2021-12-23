<?php

namespace App\DTO\Order;

use App\DTO\AbstractDTO;

/**
 * Class WarehouseInformation
 * @package App\DTO\Order
 */
class WarehouseInformation extends AbstractDTO
{
    /**
     * @var string
     */
    private string $warehouseType;
    /**
     * @var string
     */
    private string $warehouseName;
    /**
     * @var string
     */
    private string $warehouseId;

    /**
     * @return string
     */
    public function getWarehouseType(): string
    {
        return $this->warehouseType;
    }

    /**
     * @param string $warehouseType
     */
    public function setWarehouseType(string $warehouseType): void
    {
        $this->warehouseType = $warehouseType;
    }

    /**
     * @return string
     */
    public function getWarehouseName(): string
    {
        return $this->warehouseName;
    }

    /**
     * @param string $warehouseName
     */
    public function setWarehouseName(string $warehouseName): void
    {
        $this->warehouseName = $warehouseName;
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
            'warehouse_type' => $this->warehouseType,
            'warehouse_name' => $this->warehouseName,
            'warehouse_id' => $this->warehouseId
        ];
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): WarehouseInformation
    {
        $warehouseInformation = new self();
        $warehouseInformation->warehouseType = self::getValue($data, 'warehouse_type');
        $warehouseInformation->warehouseName = self::getValue($data, 'warehouse_name');
        $warehouseInformation->warehouseId = self::getValue($data, 'warehouse_id');

        return $warehouseInformation;
    }
}
