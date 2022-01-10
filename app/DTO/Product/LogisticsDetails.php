<?php

namespace App\DTO\Product;

use App\DTO\AbstractDTO;

/**
 * Class LogisticsDetails
 * @package App\DTO\Product
 */
class LogisticsDetails extends AbstractDTO
{
    /**
     * @var string
     */
    private string $originCountry;
    /**
     * @var float
     */
    private float $weight;
    /**
     * @var string
     */
    private string $customsHsCode;

    /**
     * @return string
     */
    public function getOriginCountry(): string
    {
        return $this->originCountry;
    }

    /**
     * @param string $originCountry
     */
    public function setOriginCountry(string $originCountry): void
    {
        $this->originCountry = $originCountry;
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     */
    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return string
     */
    public function getCustomsHsCode(): string
    {
        return $this->customsHsCode;
    }

    /**
     * @param string $customsHsCode
     */
    public function setCustomsHsCode(string $customsHsCode): void
    {
        $this->customsHsCode = $customsHsCode;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'origin_country' => $this->originCountry,
            'weight' => $this->weight,
            'customs_hs_code' => $this->customsHsCode
        ];
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): LogisticsDetails
    {
        $logisticsDetails = new self();
        $logisticsDetails->originCountry = self::getValue($data, 'origin_country');
        $logisticsDetails->weight = self::getValue($data, 'weight');
        $logisticsDetails->customsHsCode = self::getValue($data, 'customs_hs_code');

        return $logisticsDetails;
    }
}
