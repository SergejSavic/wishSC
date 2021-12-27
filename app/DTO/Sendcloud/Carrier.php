<?php

namespace App\DTO\Sendcloud;

use App\DTO\AbstractDTO;

/**
 * Class Carrier
 * @package App\DTO\Sendcloud
 */
class Carrier extends AbstractDTO
{
    /**
     * @var string|null
     */
    private ?string $code;

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): Carrier
    {
        $carrier = new self();
        $carrier->code = self::getValue($data, 'code');
        return $carrier;
    }
}
