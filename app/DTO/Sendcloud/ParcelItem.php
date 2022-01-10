<?php

namespace App\DTO\Sendcloud;

use App\DTO\AbstractDTO;

/**
 * Class ParcelItem
 * @package App\DTO\Sendcloud
 */
class ParcelItem extends AbstractDTO
{
    /**
     * Internal ID of the product
     *
     * @var string|null
     */
    private ?string $productId;
    /**
     * Product SKU
     *
     * @var string|null
     */
    private ?string $sku;
    /**
     * Product description
     *
     * @var string|null
     */
    private ?string $description;
    /**
     * Country two letter ISO code
     *
     * @var string|null
     */
    private ?string $originCountry;
    /**
     * Harmonized System Code
     *
     * @var string|null
     */
    private ?string $hsCode;
    /**
     * Quantity of items shipped
     *
     * @var int|null
     */
    private ?int $quantity;
    /**
     * Price value of each one of the items
     *
     * @var string|null
     */
    private ?string $itemValue;
    /**
     * Weight of each one of the items
     *
     * @var string|null
     */
    private ?string $weight;
    /**
     * The list of properties of the product in key => value manner
     *
     * @var array
     */
    private array $properties;

    /**
     * @return string|null
     */
    public function getProductId(): ?string
    {
        return $this->productId;
    }

    /**
     * @param string|null $productId
     */
    public function setProductId(?string $productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @return string|null
     */
    public function getSku(): ?string
    {
        return $this->sku;
    }

    /**
     * @param string|null $sku
     */
    public function setSku(?string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getOriginCountry(): ?string
    {
        return $this->originCountry;
    }

    /**
     * @param string|null $originCountry
     */
    public function setOriginCountry(?string $originCountry): void
    {
        $this->originCountry = $originCountry;
    }

    /**
     * @return string|null
     */
    public function getHsCode(): ?string
    {
        return $this->hsCode;
    }

    /**
     * @param string|null $hsCode
     */
    public function setHsCode(?string $hsCode): void
    {
        $this->hsCode = $hsCode;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int|null $quantity
     */
    public function setQuantity(?int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return string|null
     */
    public function getItemValue(): ?string
    {
        return $this->itemValue;
    }

    /**
     * @param string|null $itemValue
     */
    public function setItemValue(?string $itemValue): void
    {
        $this->itemValue = $itemValue;
    }

    /**
     * @return string|null
     */
    public function getWeight(): ?string
    {
        return $this->weight;
    }

    /**
     * @param string|null $weight
     */
    public function setWeight(?string $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param array $properties
     */
    public function setProperties(array $properties): void
    {
        $this->properties = $properties;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        $item = [
            'description' => $this->getDescription(),
            'hs_code' => $this->getHsCode(),
            'origin_country' => $this->getOriginCountry(),
            'product_id' => $this->getProductId(),
            'properties' => (object)$this->getProperties(),
            'quantity' => $this->getQuantity(),
            'sku' => $this->getSku(),
            'value' => $this->getItemValue(),
            'weight' => (string)round($this->getWeight(), 3),
        ];

        if ($item['weight'] == 0) {
            unset($item['weight']);
        }

        return $item;
    }

    /**
     * @inheritdoc
     * @return ParcelItem
     */
    public static function fromArray(array $data): ParcelItem
    {
        $parcelItem = new self();

        $parcelItem->productId = static::getValue($data, 'product_id');
        $parcelItem->sku = static::getValue($data, 'sku', null);
        $parcelItem->description = static::getValue($data, 'description', null);
        $parcelItem->originCountry = static::getValue($data, 'origin_country', null);
        $parcelItem->hsCode = static::getValue($data, 'hs_code', null);
        $parcelItem->quantity = static::getValue($data, 'quantity', null);
        $parcelItem->weight = static::getValue($data, 'weight', null);
        $parcelItem->itemValue = static::getValue($data, 'value', null);
        $parcelItem->properties = static::getValue($data, 'properties', []);

        return $parcelItem;
    }
}
