<?php

namespace App\DTO\Order;

use App\DTO\AbstractDTO;

/**
 * Class ShippingDetail
 * @package App\DTO\Order
 */
class ShippingDetail extends AbstractDTO
{
    /**
     * @var string
     */
    private string $city;
    /**
     * @var string
     */
    private string $country;
    /**
     * @var string
     */
    private string $streetAddress3;
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
     * @var PhoneNumber
     */
    private PhoneNumber $phoneNumber;
    /**
     * @var string
     */
    private string $region;
    /**
     * @var string
     */
    private string $neighborhood;
    /**
     * @var string
     */
    private string $name;

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
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getStreetAddress3(): string
    {
        return $this->streetAddress3;
    }

    /**
     * @param string $streetAddress3
     */
    public function setStreetAddress3(string $streetAddress3): void
    {
        $this->streetAddress3 = $streetAddress3;
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
     * @return PhoneNumber
     */
    public function getPhoneNumber(): PhoneNumber
    {
        return $this->phoneNumber;
    }

    /**
     * @param PhoneNumber $phoneNumber
     */
    public function setPhoneNumber(PhoneNumber $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion(string $region): void
    {
        $this->region = $region;
    }

    /**
     * @return string
     */
    public function getNeighborhood(): string
    {
        return $this->neighborhood;
    }

    /**
     * @param string $neighborhood
     */
    public function setNeighborhood(string $neighborhood): void
    {
        $this->neighborhood = $neighborhood;
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
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'city' => $this->city,
            'country' => $this->country,
            'street_address3' => $this->streetAddress3,
            'street_address2' => $this->streetAddress2,
            'street_address1' => $this->streetAddress1,
            'zipcode' => $this->zipcode,
            'state' => $this->state,
            'country_code' => $this->countryCode,
            'phone_number' => $this->phoneNumber->toArray(),
            'region' => $this->region,
            'neighborhood' => $this->neighborhood,
            'name' => $this->name
        ];
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): ShippingDetail
    {
        $shippingDetail = new self();
        $shippingDetail->city = self::getValue($data, 'city');
        $shippingDetail->country = self::getValue($data, 'country');
        $shippingDetail->streetAddress3 = self::getValue($data, 'street_address3');
        $shippingDetail->streetAddress2 = self::getValue($data, 'street_address2');
        $shippingDetail->streetAddress1 = self::getValue($data, 'street_address1');
        $shippingDetail->zipcode = self::getValue($data, 'zipcode');
        $shippingDetail->state = self::getValue($data, 'state');
        $shippingDetail->countryCode = self::getValue($data, 'country_code');
        $shippingDetail->phoneNumber = PhoneNumber::fromArray(self::getValue($data, 'phone_number', []));
        $shippingDetail->region = self::getValue($data, 'region');
        $shippingDetail->neighborhood = self::getValue($data, 'neighborhood');
        $shippingDetail->name = self::getValue($data, 'name');

        return $shippingDetail;
    }
}
