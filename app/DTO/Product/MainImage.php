<?php

namespace App\DTO\Product;

use App\DTO\AbstractDTO;

/**
 * Class MainImage
 * @package App\DTO\Product
 */
class MainImage extends AbstractDTO
{
    /**
     * @var string
     */
    private string $url;
    /**
     * @var bool
     */
    private bool $isCleanImage;

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return bool
     */
    public function isCleanImage(): bool
    {
        return $this->isCleanImage;
    }

    /**
     * @param bool $isCleanImage
     */
    public function setIsCleanImage(bool $isCleanImage): void
    {
        $this->isCleanImage = $isCleanImage;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'url' => $this->url,
            'is_clean_image' => $this->isCleanImage
        ];
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): MainImage
    {
        $mainImage = new self();
        $mainImage->url = self::getValue($data, 'url');
        $mainImage->isCleanImage = self::getValue($data, 'is_clean_image');

        return $mainImage;
    }
}
