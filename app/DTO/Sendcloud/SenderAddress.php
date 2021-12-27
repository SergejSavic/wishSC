<?php

namespace App\DTO\Sendcloud;

use App\DTO\AbstractDTO;

class SenderAddress extends AbstractDTO
{
    private int $id;
    private string $companyName;
    private string $contactName;
    private string $email;
    private string $telephone;
    private string $street;
    private string $houseNumber;
    private string $postalBox;
    private string $postalCode;
    private string $city;
    private string $country;
    private string $vatNumber;
    private string $cocNumber;
    private string $eoriNumber;
    private int $brandId;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     */
    public function setCompanyName(string $companyName): void
    {
        $this->companyName = $companyName;
    }

    /**
     * @return string
     */
    public function getContactName(): string
    {
        return $this->contactName;
    }

    /**
     * @param string $contactName
     */
    public function setContactName(string $contactName): void
    {
        $this->contactName = $contactName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getTelephone(): string
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getHouseNumber(): string
    {
        return $this->houseNumber;
    }

    /**
     * @param string $houseNumber
     */
    public function setHouseNumber(string $houseNumber): void
    {
        $this->houseNumber = $houseNumber;
    }

    /**
     * @return string
     */
    public function getPostalBox(): string
    {
        return $this->postalBox;
    }

    /**
     * @param string $postalBox
     */
    public function setPostalBox(string $postalBox): void
    {
        $this->postalBox = $postalBox;
    }

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
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
    public function getVatNumber(): string
    {
        return $this->vatNumber;
    }

    /**
     * @param string $vatNumber
     */
    public function setVatNumber(string $vatNumber): void
    {
        $this->vatNumber = $vatNumber;
    }

    /**
     * @return string
     */
    public function getCocNumber(): string
    {
        return $this->cocNumber;
    }

    /**
     * @param string $cocNumber
     */
    public function setCocNumber(string $cocNumber): void
    {
        $this->cocNumber = $cocNumber;
    }

    /**
     * @return string
     */
    public function getEoriNumber(): string
    {
        return $this->eoriNumber;
    }

    /**
     * @param string $eoriNumber
     */
    public function setEoriNumber(string $eoriNumber): void
    {
        $this->eoriNumber = $eoriNumber;
    }

    /**
     * @return int
     */
    public function getBrandId(): int
    {
        return $this->brandId;
    }

    /**
     * @param int $brandId
     */
    public function setBrandId(int $brandId): void
    {
        $this->brandId = $brandId;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'company_name' => $this->companyName,
            'contact_name' => $this->contactName,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'street' => $this->street,
            'house_number' => $this->houseNumber,
            'postal_box' => $this->postalBox,
            'postal_code' => $this->postalCode,
            'city' => $this->city,
            'country' => $this->country,
            'vat_number' => $this->vatNumber,
            'coc_number' => $this->cocNumber,
            'eori_number' => $this->eoriNumber,
            'brand_id' => $this->brandId
        ];
    }

    /**
     * @inheritDoc
     */
    public static function fromArray(array $data): SenderAddress
    {
        $senderAddress = new self();
        $senderAddress->id = self::getValue($data, 'id');
        $senderAddress->companyName = self::getValue($data, 'company_name');
        $senderAddress->contactName = self::getValue($data, 'contact_name');
        $senderAddress->email = self::getValue($data, 'email');
        $senderAddress->telephone = self::getValue($data, 'telephone');
        $senderAddress->street = self::getValue($data, 'street');
        $senderAddress->houseNumber = self::getValue($data, 'house_number');
        $senderAddress->postalBox = self::getValue($data, 'postal_box');
        $senderAddress->postalCode = self::getValue($data, 'postal_code');
        $senderAddress->city = self::getValue($data, 'city');
        $senderAddress->country = self::getValue($data, 'country');
        $senderAddress->vatNumber = self::getValue($data, 'vat_number');
        $senderAddress->cocNumber = self::getValue($data, 'coc_number');
        $senderAddress->eoriNumber = self::getValue($data, 'eori_number');
        $senderAddress->brandId = self::getValue($data, 'brand_id');

        return $senderAddress;
    }
}
