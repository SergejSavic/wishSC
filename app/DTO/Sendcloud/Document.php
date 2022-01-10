<?php

namespace App\DTO\Sendcloud;

use App\DTO\AbstractDTO;

/**
 * Class Document
 * @package App\DTO\Sendcloud
 */
class Document extends AbstractDTO
{
    /**
     * @var string|null
     */
    private ?string $type;
    /**
     * @var string|null
     */
    private ?string $size;
    /**
     * @var string|null
     */
    private ?string $link;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getSize(): ?string
    {
        return $this->size;
    }

    /**
     * @param string|null $size
     */
    public function setSize(?string $size): void
    {
        $this->size = $size;
    }

    /**
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string|null $link
     */
    public function setLink(?string $link): void
    {
        $this->link = $link;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'size' => $this->size,
            'link' => $this->link
        ];
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): Document
    {

        $document = new self();
        $document->type = self::getValue($data, 'type');
        $document->size = self::getValue($data, 'size');
        $document->link = self::getValue($data, 'link');

        return $document;
    }
}
