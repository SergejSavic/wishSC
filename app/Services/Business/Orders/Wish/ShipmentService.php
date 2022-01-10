<?php

namespace App\Services\Business\Orders\Wish;

use App\Contracts\Orders\Carriers\CarrierNamesInterface;
use App\Contracts\Proxy\WishProxyInterface;
use App\Contracts\Services\Orders\Wish\ShipmentServiceInterface;
use App\DTO\Sendcloud\Parcel;
use App\DTO\Shipment\Tracking;

/**
 * Class ShipmentService
 * @package App\Services\Business\Tracking\Wish
 */
class ShipmentService implements ShipmentServiceInterface
{
    private const SHIP_NOTE = 'Sendcloud';

    /**
     * @var WishProxyInterface
     */
    private WishProxyInterface $wishProxy;

    /**
     * ShipmentService constructor.
     */
    public function __construct(WishProxyInterface $wishProxy)
    {
        $this->wishProxy = $wishProxy;
    }

    /**
     * @inheritdoc
     */
    public function fulfillOrder(Parcel $parcel, string $orderId): void
    {
        $tracking = $this->getTracking($parcel);

        $this->wishProxy->updateOrderTracking($tracking, $orderId);
    }

    /**
     * Create tracking for shipment
     *
     * @param Parcel $parcel
     * @return Tracking
     */
    private function getTracking(Parcel $parcel): Tracking
    {
        $tracking = new Tracking();
        $tracking->setOriginCountry($parcel->getCountry()->getIso2());
        $tracking->setShippingProvider($this->getShippingProvider($parcel));
        $tracking->setTrackingNumber($parcel->getTrackingNumber());
        $tracking->setShipNote(self::SHIP_NOTE);

        return $tracking;
    }

    /**
     * @param Parcel $parcel
     * @return string|null
     */
    private function getShippingProvider(Parcel $parcel): ?string
    {
        $shippingProvider = '';

        if (array_key_exists($parcel->getCarrier()->getCode(), CarrierNamesInterface::WISH_CARRIERS_NAME_MAPPING)) {
            $shippingProvider = CarrierNamesInterface::WISH_CARRIERS_NAME_MAPPING[$parcel->getCarrier()->getCode()];
        }

        return $shippingProvider;
    }
}
