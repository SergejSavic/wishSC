<?php

namespace App\DTO\Order;

use App\DTO\AbstractDTO;

/**
 * Class PhoneNumber
 * @package App\DTO\Order
 */
class PhoneNumber extends AbstractDTO
{
    /**
     * @var string
     */
    private string $number;
    /**
     * @var string
     */
    private string $countryCode;

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
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
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'number' => $this->number,
            'country_code' => $this->countryCode
        ];
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): PhoneNumber
    {
        $phone = new self();
        $phone->number = self::getValue($data, 'number');
        $phone->countryCode = self::getValue($data, 'country_code');

        return $phone;
    }
}
