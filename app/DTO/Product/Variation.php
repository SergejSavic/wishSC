<?php

namespace App\DTO\Product;

use App\DTO\AbstractDTO;

/**
 * Class Variation
 * @package App\DTO\Product
 */
class Variation extends AbstractDTO
{
    /**
     * @var string
     */
    private string $sku;
    /**
     * @var string
     */
    private string $status;
    /**
     * @var string
     */
    private string $productId;
    /**
     * @var Price
     */
    private Price $price;
    /**
     * @var string
     */
    private string $id;
    /**
     * @var Cost
     */
    private Cost $cost;
    /**
     * @var string
     */
    private string $gtin;
    /**
     * @var Inventory[]
     */
    private array $inventories;
    /**
     * @var LogisticsDetails
     */
    private LogisticsDetails $logisticsDetails;

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     */
    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * @param string $productId
     */
    public function setProductId(string $productId): void
    {
        $this->productId = $productId;
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
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Cost
     */
    public function getCost(): Cost
    {
        return $this->cost;
    }

    /**
     * @param Cost $cost
     */
    public function setCost(Cost $cost): void
    {
        $this->cost = $cost;
    }

    /**
     * @return string
     */
    public function getGtin(): string
    {
        return $this->gtin;
    }

    /**
     * @param string $gtin
     */
    public function setGtin(string $gtin): void
    {
        $this->gtin = $gtin;
    }

    /**
     * @return Inventory[]
     */
    public function getInventories(): array
    {
        return $this->inventories;
    }

    /**
     * @param Inventory[] $inventories
     */
    public function setInventories(array $inventories): void
    {
        $this->inventories = $inventories;
    }

    /**
     * @return LogisticsDetails
     */
    public function getLogisticsDetails(): LogisticsDetails
    {
        return $this->logisticsDetails;
    }

    /**
     * @param LogisticsDetails $logisticsDetails
     */
    public function setLogisticsDetails(LogisticsDetails $logisticsDetails): void
    {
        $this->logisticsDetails = $logisticsDetails;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'sku' => $this->sku,
            'status' => $this->status,
            'product_id' => $this->productId,
            'price' => $this->price->toArray(),
            'id' => $this->id,
            'cost' => $this->cost->toArray(),
            'gtin' => $this->gtin,
            'inventories' => self::toBatch($this->inventories),
            'logistics_details' => $this->logisticsDetails->toArray()
        ];
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): Variation
    {
        $variation = new self();
        $variation->sku = self::getValue($data, 'sku');
        $variation->status = self::getValue($data, 'status');
        $variation->productId = self::getValue($data, 'product_id');
        $variation->price = Price::fromArray(self::getValue($data, 'price', []));
        $variation->id = self::getValue($data, 'id');
        $variation->cost = Cost::fromArray(self::getValue($data, 'cost', []));
        $variation->gtin = self::getValue($data, 'gtin');
        $variation->inventories = Inventory::fromBatch(self::getValue($data, 'inventories', []));
        $variation->logisticsDetails = LogisticsDetails::fromArray(self::getValue($data, 'logistics_details', []));

        return $variation;
    }
}
