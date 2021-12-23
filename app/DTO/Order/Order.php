<?php

namespace App\DTO\Order;

use App\DTO\AbstractDTO;
use DateTime;
use Exception;

/**
 * Class Order
 * @package App\DTO\Order
 */
class Order extends AbstractDTO
{
    /**
     * @var string
     */
    private string $id;
    /**
     * @var WarehouseInformation
     */
    private WarehouseInformation $warehouseInformation;
    /**
     * @var OrderPayment
     */
    private OrderPayment $orderPayment;
    /**
     * @var ProductInformation
     */
    private ProductInformation $productInformation;
    /**
     * @var DateTime
     */
    private DateTime $releasedAt;
    /**
     * @var DateTime
     */
    private DateTime $updatedAt;
    /**
     * @var FullAddress
     */
    private FullAddress $fullAddress;
    /**
     * @var FulfillmentRequirements
     */
    private FulfillmentRequirements $fulfillmentRequirements;
    /**
     * @var string
     */
    private string $state;
    /**
     * @var string
     */
    private string $transactionId;
    /**
     * @var array
     */
    private array $fulfillmentOrderTypes;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return WarehouseInformation
     */
    public function getWarehouseInformation(): WarehouseInformation
    {
        return $this->warehouseInformation;
    }

    /**
     * @param WarehouseInformation $warehouseInformation
     */
    public function setWarehouseInformation(WarehouseInformation $warehouseInformation): void
    {
        $this->warehouseInformation = $warehouseInformation;
    }

    /**
     * @return OrderPayment
     */
    public function getOrderPayment(): OrderPayment
    {
        return $this->orderPayment;
    }

    /**
     * @param OrderPayment $orderPayment
     */
    public function setOrderPayment(OrderPayment $orderPayment): void
    {
        $this->orderPayment = $orderPayment;
    }

    /**
     * @return ProductInformation
     */
    public function getProductInformation(): ProductInformation
    {
        return $this->productInformation;
    }

    /**
     * @param ProductInformation $productInformation
     */
    public function setProductInformation(ProductInformation $productInformation): void
    {
        $this->productInformation = $productInformation;
    }

    /**
     * @return DateTime
     */
    public function getReleasedAt(): DateTime
    {
        return $this->releasedAt;
    }

    /**
     * @param DateTime $releasedAt
     */
    public function setReleasedAt(DateTime $releasedAt): void
    {
        $this->releasedAt = $releasedAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return FullAddress
     */
    public function getFullAddress(): FullAddress
    {
        return $this->fullAddress;
    }

    /**
     * @param FullAddress $fullAddress
     */
    public function setFullAddress(FullAddress $fullAddress): void
    {
        $this->fullAddress = $fullAddress;
    }

    /**
     * @return FulfillmentRequirements
     */
    public function getFulfillmentRequirements(): FulfillmentRequirements
    {
        return $this->fulfillmentRequirements;
    }

    /**
     * @param FulfillmentRequirements $fulfillmentRequirements
     */
    public function setFulfillmentRequirements(FulfillmentRequirements $fulfillmentRequirements): void
    {
        $this->fulfillmentRequirements = $fulfillmentRequirements;
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
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * @param string $transactionId
     */
    public function setTransactionId(string $transactionId): void
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @return array
     */
    public function getFulfillmentOrderTypes(): array
    {
        return $this->fulfillmentOrderTypes;
    }

    /**
     * @param array $fulfillmentOrderTypes
     */
    public function setFulfillmentOrderTypes(array $fulfillmentOrderTypes): void
    {
        $this->fulfillmentOrderTypes = $fulfillmentOrderTypes;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'warehouse_information' => $this->warehouseInformation->toArray(),
            'order_payment' => $this->orderPayment->toArray(),
            'released_at' => $this->releasedAt,
            'updated_at' => $this->updatedAt,
            'product_information' => $this->productInformation->toArray(),
            'full_address' => $this->fullAddress->toArray(),
            'fulfillment_requirements' => $this->fulfillmentRequirements->toArray(),
            'state' => $this->state,
            'transaction_id' => $this->transactionId,
            'fulfillment_order_types' => $this->fulfillmentOrderTypes
        ];
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    public static function fromArray(array $data): Order
    {
        $order = new self();
        $order->id = self::getValue($data, 'id');
        $order->warehouseInformation = WarehouseInformation::fromArray(self::getValue($data, 'warehouse_information', []));
        $order->orderPayment = OrderPayment::fromArray(self::getValue($data, 'order_payment', []));
        $order->productInformation = ProductInformation::fromArray(self::getValue($data, 'product_information', []));
        $order->releasedAt = new DateTime(self::getValue($data, 'released_at'));
        $order->updatedAt = new DateTime(self::getValue($data, 'updated_at'));
        $order->fullAddress = FullAddress::fromArray(self::getValue($data, 'full_address', []));
        $order->fulfillmentRequirements = FulfillmentRequirements::fromArray(self::getValue($data, 'fulfillment_requirements', []));
        $order->state = self::getValue($data, 'state');
        $order->transactionId = self::getValue($data, 'transaction_id');
        $order->fulfillmentOrderTypes = self::getValue($data, 'fulfillment_order_types');

        return $order;
    }
}
