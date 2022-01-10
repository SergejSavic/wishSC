<?php

namespace App\DTO\Sendcloud;

use App\DTO\AbstractDTO;

/**
 * Class AddressDivided
 * @package App\DTO\Sendcloud
 */
class AddressDivided extends AbstractDTO
{
    /**
     * @var string|null
     */
    private ?string $street;
    /**
     * @var string|null
     */
    private ?string $houseNumber;

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string|null $street
     */
    public function setStreet(?string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return string|null
     */
    public function getHouseNumber(): ?string
    {
        return $this->houseNumber;
    }

    /**
     * @param string|null $houseNumber
     */
    public function setHouseNumber(?string $houseNumber): void
    {
        $this->houseNumber = $houseNumber;
    }


    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'house_number' => $this->houseNumber,
            'street' => $this->street,
        ];
    }

    /**
     * @inheritDoc
     */
    public static function fromArray(array $data): AddressDivided
    {
        $addressDivided = new self();
        $addressDivided->houseNumber = static::getValue($data, 'house_number');
        $addressDivided->street = static::getValue($data, 'street');

        return $addressDivided;
    }
}
