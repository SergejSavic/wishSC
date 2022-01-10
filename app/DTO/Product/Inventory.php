<?php

namespace App\DTO\Product;

use App\DTO\AbstractDTO;

/**
 * Class Inventory
 * @package App\DTO\Product
 */
class Inventory extends AbstractDTO
{
    /**
     * @var int
     */
    private int $inventory;
    /**
     * @var string
     */
    private string $warehouseId;

    /**
     * @return int
     */
    public function getInventory(): int
    {
        return $this->inventory;
    }

    /**
     * @param int $inventory
     */
    public function setInventory(int $inventory): void
    {
        $this->inventory = $inventory;
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
            'inventory' => $this->inventory,
            'warehouse_id' => $this->warehouseId
        ];
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): Inventory
    {
        $inventory = new self();
        $inventory->inventory = self::getValue($data, 'inventory');
        $inventory->warehouseId = self::getValue($data, 'warehouse_id');

        return $inventory;
    }
}
