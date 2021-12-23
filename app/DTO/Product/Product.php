<?php

namespace App\DTO\Product;

use App\DTO\AbstractDTO;
use DateTime;
use Exception;

/**
 * Class Product
 * @package App\DTO\Product
 */
class Product extends AbstractDTO
{
    /**
     * @var DateTime
     */
    private DateTime $updatedAt;
    /**
     * @var WarehouseToShipping[]
     */
    private array $warehouseToShippings;
    /**
     * @var int
     */
    private int $numSold;
    /**
     * @var string
     */
    private string $id;
    /**
     * @var string
     */
    private string $unit;
    /**
     * @var string
     */
    private string $category;
    /**
     * @var bool
     */
    private bool $isPromoted;
    /**
     * @var string
     */
    private string $status;
    /**
     * @var DefaultShippingPrices[]
     */
    private array $defaultShippingPrices;
    /**
     * @var string
     */
    private string $description;
    /**
     * @var array
     */
    private array $tags;
    /**
     * @var int
     */
    private int $numSaves;
    /**
     * @var string
     */
    private string $parentSku;
    /**
     * @var string
     */
    private string $condition;
    /**
     * @var MainImage
     */
    private MainImage $mainImage;
    /**
     * @var string
     */
    private string $name;
    /**
     * @var string
     */
    private string $brandId;
    /**
     * @var DateTime
     */
    private DateTime $createdAt;
    /**
     * @var Variation[]
     */
    private array $variations;

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return WarehouseToShipping[]
     */
    public function getWarehouseToShippings(): array
    {
        return $this->warehouseToShippings;
    }

    /**
     * @param WarehouseToShipping[] $warehouseToShippings
     */
    public function setWarehouseToShippings(array $warehouseToShippings): void
    {
        $this->warehouseToShippings = $warehouseToShippings;
    }

    /**
     * @return int
     */
    public function getNumSold(): int
    {
        return $this->numSold;
    }

    /**
     * @param int numSold
     */
    public function setNumSold(int $numSold): void
    {
        $this->numSold = $numSold;
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
     * @return string
     */
    public function getUnit(): string
    {
        return $this->unit;
    }

    /**
     * @param string $unit
     */
    public function setUnit(string $unit): void
    {
        $this->unit = $unit;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * @return bool
     */
    public function isPromoted(): bool
    {
        return $this->isPromoted;
    }

    /**
     * @param bool $isPromoted
     */
    public function setIsPromoted(bool $isPromoted): void
    {
        $this->isPromoted = $isPromoted;
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
     * @return DefaultShippingPrices[]
     */
    public function getDefaultShippingPrices(): array
    {
        return $this->defaultShippingPrices;
    }

    /**
     * @param DefaultShippingPrices[] $defaultShippingPrices
     */
    public function setDefaultShippingPrices(array $defaultShippingPrices): void
    {
        $this->defaultShippingPrices = $defaultShippingPrices;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return int
     */
    public function getNumSaves(): int
    {
        return $this->numSaves;
    }

    /**
     * @param int $numSaves
     */
    public function setNumSaves(int $numSaves): void
    {
        $this->numSaves = $numSaves;
    }

    /**
     * @return string
     */
    public function getParentSku(): string
    {
        return $this->parentSku;
    }

    /**
     * @param string $parentSku
     */
    public function setParentSku(string $parentSku): void
    {
        $this->parentSku = $parentSku;
    }

    /**
     * @return string
     */
    public function getCondition(): string
    {
        return $this->condition;
    }

    /**
     * @param string $condition
     */
    public function setCondition(string $condition): void
    {
        $this->condition = $condition;
    }

    /**
     * @return MainImage
     */
    public function getMainImage(): MainImage
    {
        return $this->mainImage;
    }

    /**
     * @param MainImage $mainImage
     */
    public function setMainImage(MainImage $mainImage): void
    {
        $this->mainImage = $mainImage;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getBrandId(): string
    {
        return $this->brandId;
    }

    /**
     * @param string $brandId
     */
    public function setBrandId(string $brandId): void
    {
        $this->brandId = $brandId;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return Variation[]
     */
    public function getVariations(): array
    {
        return $this->variations;
    }

    /**
     * @param Variation[] $variations
     */
    public function setVariations(array $variations): void
    {
        $this->variations = $variations;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'updated_at' => $this->updatedAt,
            'warehouse_to_shippings' => self::toBatch($this->warehouseToShippings),
            'num_sold' => $this->numSold,
            'id' => $this->id,
            'unit' => $this->unit,
            'category' => $this->category,
            'is_promoted' => $this->isPromoted,
            'status' => $this->status,
            'default_shipping_prices' => self::toBatch($this->defaultShippingPrices),
            'description' => $this->description,
            'tags' => $this->tags,
            'num_saves' => $this->numSaves,
            'parent_sku' => $this->parentSku,
            'condition' => $this->condition,
            'mainImage' => $this->mainImage->toArray(),
            'name' => $this->name,
            'brand_id' => $this->brandId,
            'created_at' => $this->createdAt,
            'variations' => self::toBatch($this->variations)
        ];
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    public static function fromArray(array $data): Product
    {
        $product = new self();
        $product->updatedAt = new DateTime(self::getValue($data, 'updated_at'));
        $product->warehouseToShippings = WarehouseToShipping::fromBatch(self::getValue($data, 'warehouse_to_shippings', []));
        $product->numSold = self::getValue($data, 'num_sold');
        $product->id = self::getValue($data, 'id');
        $product->unit = self::getValue($data, 'unit');
        $product->category = self::getValue($data, 'category');
        $product->isPromoted = self::getValue($data, 'is_promoted');
        $product->status = self::getValue($data, 'status');
        $product->defaultShippingPrices = DefaultShippingPrices::fromBatch(self::getValue($data, 'default_shipping_prices', []));
        $product->description = self::getValue($data, 'description');
        $product->tags = self::getValue($data, 'tags');
        $product->numSaves = self::getValue($data, 'num_saves');
        $product->parentSku = self::getValue($data, 'parent_sku');
        $product->condition = self::getValue($data, 'condition');
        $product->mainImage = MainImage::fromArray(self::getValue($data, 'main_image', []));
        $product->name = self::getValue($data, 'name');
        $product->brandId = self::getValue($data, 'brand_id');
        $product->createdAt = new DateTime(self::getValue($data, 'created_at'));
        $product->variations = Variation::fromBatch(self::getValue($data, 'variations', []));

        return $product;
    }
}
