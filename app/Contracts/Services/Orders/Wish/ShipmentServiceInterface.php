<?php

namespace App\Contracts\Services\Orders\Wish;

use App\DTO\Sendcloud\Parcel;

interface ShipmentServiceInterface
{
    /**
     * add/update order tracking information
     *
     * @param Parcel $parcel
     * @param string $orderId
     */
    public function fulfillOrder(Parcel $parcel, string $orderId):void;
}