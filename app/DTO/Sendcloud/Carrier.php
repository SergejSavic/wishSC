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
     * @var string|null
     */
    private ?string $name;

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
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'name' => $this->name
        ];
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): Carrier
    {
        $carrier = new self();
        $carrier->code = self::getValue($data, 'code');
        $carrier->name = self::getValue($data, 'name');
        return $carrier;
    }
}
