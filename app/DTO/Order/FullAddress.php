<?php

namespace App\DTO\Order;

use App\DTO\AbstractDTO;

/**
 * Class FullAddress
 * @package App\DTO\Order
 */
class FullAddress extends AbstractDTO
{
    /**
     * @var ShippingDetail
     */
    private ShippingDetail $shippingDetail;

    /**
     * @return ShippingDetail
     */
    public function getShippingDetail(): ShippingDetail
    {
        return $this->shippingDetail;
    }

    /**
     * @param ShippingDetail $shippingDetail
     */
    public function setShippingDetail(ShippingDetail $shippingDetail): void
    {
        $this->shippingDetail = $shippingDetail;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'shipping_detail' => $this->shippingDetail->toArray()
        ];
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): FullAddress
    {
        $fullAddress = new self();
        $fullAddress->shippingDetail = ShippingDetail::fromArray(self::getValue($data, 'shipping_detail', []));

        return $fullAddress;
    }
}
