<?php

namespace App\DTO\Shipment;

use App\DTO\AbstractDTO;

/**
 * Class Tracking
 * @package App\DTO\Shipment
 */
class Tracking extends AbstractDTO
{
    /**
     * @var string
     */
    private string $originCountry;
    /**
     * @var string
     */
    private string $shippingProvider;
    /**
     * @var string
     */
    private string $trackingNumber;
    /**
     * @var string
     */
    private string $shipNote;

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
     * @return string
     */
    public function getShippingProvider(): string
    {
        return $this->shippingProvider;
    }

    /**
     * @param string $shippingProvider
     */
    public function setShippingProvider(string $shippingProvider): void
    {
        $this->shippingProvider = $shippingProvider;
    }

    /**
     * @return string
     */
    public function getTrackingNumber(): string
    {
        return $this->trackingNumber;
    }

    /**
     * @param string $trackingNumber
     */
    public function setTrackingNumber(string $trackingNumber): void
    {
        $this->trackingNumber = $trackingNumber;
    }

    /**
     * @return string
     */
    public function getShipNote(): string
    {
        return $this->shipNote;
    }

    /**
     * @param string $shipNote
     */
    public function setShipNote(string $shipNote): void
    {
        $this->shipNote = $shipNote;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'origin_country' => $this->originCountry,
            'shipping_provider' => $this->shippingProvider,
            'tracking_number' => $this->trackingNumber,
            'ship_note' => $this->shipNote
        ];
    }

    /**
     * @inheritDoc
     */
    public static function fromArray(array $data): AbstractDTO
    {
        $tracking = new self();
        $tracking->originCountry = self::getValue($data, 'origin_country');
        $tracking->shippingProvider = self::getValue($data, 'shipping_provider');
        $tracking->trackingNumber = self::getValue($data, 'tracking_number');
        $tracking->shipNote = self::getValue($data, 'ship_note');

        return $tracking;
    }
}
