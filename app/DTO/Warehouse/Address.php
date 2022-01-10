<?php

namespace App\DTO\Warehouse;

use App\DTO\AbstractDTO;

/**
 * Class Address
 * @package App\DTO\Shipment
 */
class Address extends AbstractDTO
{
    /**
     * @var string
     */
    private string $city;
    /**
     * @var string
     */
    private string $shipToName;
    /**
     * @var string
     */
    private string $streetAddress2;
    /**
     * @var string
     */
    private string $streetAddress1;
    /**
     * @var string
     */
    private string $zipcode;
    /**
     * @var string
     */
    private string $state;
    /**
     * @var string
     */
    private string $countryCode;

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode(string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getShipToName(): string
    {
        return $this->shipToName;
    }

    /**
     * @param string $shipToName
     */
    public function setShipToName(string $shipToName): void
    {
        $this->shipToName = $shipToName;
    }

    /**
     * @return string
     */
    public function getStreetAddress2(): string
    {
        return $this->streetAddress2;
    }

    /**
     * @param string $streetAddress2
     */
    public function setStreetAddress2(string $streetAddress2): void
    {
        $this->streetAddress2 = $streetAddress2;
    }

    /**
     * @return string
     */
    public function getStreetAddress1(): string
    {
        return $this->streetAddress1;
    }

    /**
     * @param string $streetAddress1
     */
    public function setStreetAddress1(string $streetAddress1): void
    {
        $this->streetAddress1 = $streetAddress1;
    }

    /**
     * @return string
     */
    public function getZipcode(): string
    {
        return $this->zipcode;
    }

    /**
     * @param string $zipcode
     */
    public function setZipcode(string $zipcode): void
    {
        $this->zipcode = $zipcode;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState(string $state): void
    {
        $this->state = $state;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'city' => $this->city,
            'ship_to_name' => $this->shipToName,
            'street_address2' => $this->streetAddress2,
            'street_address1' => $this->streetAddress1,
            'zipcode' => $this->zipcode,
            'state' => $this->state,
            'country_code' => $this->countryCode
        ];
    }

    /**
     * @inheritDoc
     */
    public static function fromArray(array $data): Address
    {
        $address = new self();
        $address->city = self::getValue($data, 'city');
        $address->shipToName = self::getValue($data, 'ship_to_name');
        $address->streetAddress2 = self::getValue($data, 'street_address2');
        $address->streetAddress1 = self::getValue($data, 'street_address1');
        $address->zipcode = self::getValue($data, 'zipcode');
        $address->state = self::getValue($data, 'state');
        $address->countryCode = self::getValue($data, 'country_code');

        return $address;
    }
}
