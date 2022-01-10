<?php

namespace App\Contracts\Proxy;

use App\DTO\Order\Order;
use App\DTO\Product\Product;
use App\DTO\Refund\Refund;
use App\DTO\Shipment\Tracking;
use App\DTO\Warehouse\Warehouse;
use DateTime;

interface WishProxyInterface
{
    /**
     * Retrieves orders
     *
     * @param DateTime $date
     * @param string $status
     * @return Order[]
     */
    public function getOrders(DateTime $date, string $status): array;
    /**
     * Retrieves order based on order id
     *
     * @param string $id
     * @return Order|null
     */
    public function getOrderById(string $id): ?Order;
    /**
     * Update the carrier tracking information for specific order
     *
     * @param Tracking $tracking
     * @param string $orderId
     */
    public function updateOrderTracking(Tracking $tracking, string $orderId): void;

    /**
     * Create Refund for an order
     *
     * @param Refund $refund
     * @param string $orderId
     */
    public function createRefund(Refund $refund, string $orderId): void;

    /**
     * Retrieves warehouses
     *
     * @return Warehouse[]|null
     */
    public function getWarehouses(): ?array;

    /**
     * Retrieves product based on product id
     *
     * @param string $productId
     * @return Product|null
     */
    public function getProduct(string $productId): ?Product;
}
