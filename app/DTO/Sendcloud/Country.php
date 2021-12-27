<?php

namespace App\DTO\Sendcloud;

use App\DTO\AbstractDTO;

/**
 * Class Country
 * @package App\DTO\Sendcloud
 */
class Country extends AbstractDTO
{
    /**
     * @var string|null
     */
    private ?string $iso2;
    /**
     * @var string|null
     */
    private ?string $iso3;
    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @return string|null
     */
    public function getIso2(): ?string
    {
        return $this->iso2;
    }

    /**
     * @param string|null $iso2
     */
    public function setIso2(?string $iso2): void
    {
        $this->iso2 = $iso2;
    }

    /**
     * @return string|null
     */
    public function getIso3(): ?string
    {
        return $this->iso3;
    }

    /**
     * @param string|null $iso3
     */
    public function setIso3(?string $iso3): void
    {
        $this->iso3 = $iso3;
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
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'iso_2' => $this->iso2,
            'iso_3' => $this->iso3,
            'name' => $this->name,
        ];
    }

    /**
     * @param array $data
     * @return Country
     */
    public static function fromArray(array $data): Country
    {
        $country = new self();
        $country->iso2 = static::getValue($data, 'iso_2', null);
        $country->iso3 = static::getValue($data, 'iso_3', null);
        $country->name = static::getValue($data, 'name', null);

        return $country;
    }
}
