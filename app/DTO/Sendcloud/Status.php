<?php

namespace App\DTO\Sendcloud;

use App\DTO\AbstractDTO;

/**
 * Class Status
 * @package App\DTO\Sendcloud
 */
class Status extends AbstractDTO
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var string|null
     */
    private ?string $message;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     */
    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'message' => $this->message
        ];
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): Status
    {
        $status = new self();
        $status->id = self::getValue($data, 'id');
        $status->message = self::getValue($data, 'message');

        return $status;
    }
}
