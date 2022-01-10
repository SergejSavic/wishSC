<?php

namespace App\DTO\Warehouse;

use App\DTO\AbstractDTO;

/**
 * Class Warehouse
 * @package App\DTO\Shipment
 */
class Warehouse extends AbstractDTO
{
    /**
     * @var string
     */
    private string $shippingType;
    /**
     * @var array
     */
    private array $destinationCountries;
    /**
     * @var string
     */
    private string $id;
    /**
     * @var string
     */
    private string $name;
    /**
     * @var Address
     */
    private Address $address;

    /**
     * @return string
     */
    public function getShippingType(): string
    {
        return $this->shippingType;
    }

    /**
     * @param string $shippingType
     */
    public function setShippingType(string $shippingType): void
    {
        $this->shippingType = $shippingType;
    }

    /**
     * @return array
     */
    public function getDestinationCountries(): array
    {
        return $this->destinationCountries;
    }

    /**
     * @param array $destinationCountries
     */
    public function setDestinationCountries(array $destinationCountries): void
    {
        $this->destinationCountries = $destinationCountries;
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
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'shipping_type' => $this->shippingType,
            'destination_countries' => $this->destinationCountries,
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address->toArray()
        ];
    }

    /**
     * @inheritDoc
     */
    public static function fromArray(array $data): Warehouse
    {
        $warehouse = new self();
        $warehouse->shippingType = self::getValue($data, 'shipping_type');
        $warehouse->destinationCountries = self::getValue($data, 'destination_countries');
        $warehouse->id = self::getValue($data, 'id');
        $warehouse->name = self::getValue($data, 'name');
        $warehouse->address = Address::fromArray(self::getValue($data, 'address', []));

        return $warehouse;
    }
}
