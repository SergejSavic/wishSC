<?php

namespace App\Services\Business\Orders\Wish;

use App\Contracts\Proxy\WishProxyInterface;
use App\Contracts\Services\Orders\Wish\ShipmentServiceInterface;
use App\DTO\Sendcloud\Parcel;
use App\DTO\Shipment\Tracking;

/**
 * Class ShipmentService
 * @package App\Services\Business\Orders\Wish
 */
class ShipmentService implements ShipmentServiceInterface
{
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
        $tracking->setShippingProvider('');
        $tracking->setTrackingNumber($parcel->getTrackingNumber());
        $tracking->setShipNote('Sendcloud');

        return $tracking;
    }
}
