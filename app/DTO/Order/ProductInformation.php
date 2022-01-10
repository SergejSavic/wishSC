<?php

namespace App\DTO\Order;

use App\DTO\AbstractDTO;

/**
 * Class ProductInformation
 * @package App\DTO\Order
 */
class ProductInformation extends AbstractDTO
{
    /**
     * @var string
     */
    private string $sku;
    /**
     * @var string
     */
    private string $name;
    /**
     * @var string
     */
    private string $color;
    /**
     * @var string
     */
    private string $manufacturedCountry;
    /**
     * @var string
     */
    private string $variationImageUrl;
    /**
     * @var string
     */
    private string $variationId;
    /**
     * @var string
     */
    private string $id;
    /**
     * @var string
     */
    private string $size;

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
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    /**
     * @return string
     */
    public function getManufacturedCountry(): string
    {
        return $this->manufacturedCountry;
    }

    /**
     * @param string $manufacturedCountry
     */
    public function setManufacturedCountry(string $manufacturedCountry): void
    {
        $this->manufacturedCountry = $manufacturedCountry;
    }

    /**
     * @return string
     */
    public function getVariationImageUrl(): string
    {
        return $this->variationImageUrl;
    }

    /**
     * @param string $variationImageUrl
     */
    public function setVariationImageUrl(string $variationImageUrl): void
    {
        $this->variationImageUrl = $variationImageUrl;
    }

    /**
     * @return string
     */
    public function getVariationId(): string
    {
        return $this->variationId;
    }

    /**
     * @param string $variationId
     */
    public function setVariationId(string $variationId): void
    {
        $this->variationId = $variationId;
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
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize(string $size): void
    {
        $this->size = $size;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'color' => $this->color,
            'manufactured_country' => $this->manufacturedCountry,
            'variation_image_url' => $this->variationImageUrl,
            'variation_id' => $this->variationId,
            'id' => $this->id,
            'size' => $this->size
        ];
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): ProductInformation
    {
        $productInformation = new self();
        $productInformation->sku = self::getValue($data, 'sku');
        $productInformation->name = self::getValue($data, 'name');
        $productInformation->color = self::getValue($data, 'color');
        $productInformation->manufacturedCountry = self::getValue($data, 'manufactured_country');
        $productInformation->variationImageUrl = self::getValue($data, 'variation_image_url');
        $productInformation->variationId = self::getValue($data, 'variation_id');
        $productInformation->id = self::getValue($data, 'id');
        $productInformation->size = self::getValue($data, 'size');

        return $productInformation;
    }
}
