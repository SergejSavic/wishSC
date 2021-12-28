<?php

namespace App\Services\Business\Orders\Sendcloud;

use App\Contracts\Services\Orders\Wish\RefundServiceInterface;
use App\Contracts\Services\Orders\Wish\ShipmentServiceInterface;
use App\Contracts\Services\RefundReasonServiceInterface;
use App\DTO\Product\Product;
use App\DTO\Product\Variation;
use App\DTO\Sendcloud\Parcel;
use App\Proxy\Sendcloud\SendcloudProxy;
use App\Proxy\WishProxy;
use App\Services\Business\Configuration\ConfigurationService;
use DateTime;
use Exception;
use JsonException;
use SendCloud\BusinessLogic\Entity\OrderItem;
use SendCloud\Infrastructure\Interfaces\Required\Configuration;
use SendCloud\BusinessLogic\Entity\Order;
use App\DTO\Order\Order as WishOrder;
use Carbon\Carbon;
use SendCloud\BusinessLogic\Interfaces\OrderService as OrderServiceInterface;
use SendCloud\Infrastructure\Logger\Logger;
use SendCloud\Infrastructure\ServiceRegister;
use SendCloud\Infrastructure\Utility\Exceptions\HttpAuthenticationException;
use SendCloud\Infrastructure\Utility\Exceptions\HttpCommunicationException;
use SendCloud\Infrastructure\Utility\Exceptions\HttpRequestException;
use SendCloud\BusinessLogic\Proxy;

/**
 * Class OrderService
 * @package App\Services\Business\Orders\Sendcloud
 */
class OrderService implements OrderServiceInterface
{
    const WISH_ORDER_STATE = 'APPROVED';

    /** * fulfillment statuses handled by Wish */
    private array $fulfillmentStatuses = ['FULFILLED_BY_WISH', 'FULFILLED_BY_STORE', 'ADVANCED_LOGISTICS'];

    /**
     * @var WishProxy
     */
    private WishProxy $proxy;

    /**
     * @var ConfigurationService
     */
    private Configuration $configurationService;

    /**
     * @var RefundServiceInterface
     */
    private RefundServiceInterface $refundService;

    /**
     * @var RefundReasonServiceInterface
     */
    private RefundReasonServiceInterface $refundReasonService;
    /**
     * @var ShipmentServiceInterface
     */
    private ShipmentServiceInterface $shippingService;

    /**
     * @var SendcloudProxy
     */
    private SendcloudProxy $sendcloudProxy;

    /**
     * OrderService constructor.
     *
     * @param WishProxy $proxy
     * @param Configuration $configurationService
     * @param SendcloudProxy $sendcloudProxy
     * @param RefundServiceInterface $refundService
     * @param RefundReasonServiceInterface $refundReasonService
     * @param ShipmentServiceInterface $shippingService
     */
    public function __construct(
        WishProxy $proxy,
        Configuration $configurationService,
        SendcloudProxy $sendcloudProxy,
        RefundServiceInterface $refundService,
        RefundReasonServiceInterface $refundReasonService,
        ShipmentServiceInterface $shippingService
    )
    {
        $this->proxy = $proxy;
        $this->configurationService = $configurationService;
        $this->sendcloudProxy = $sendcloudProxy;
        $this->refundService = $refundService;
        $this->refundReasonService = $refundReasonService;
        $this->shippingService = $shippingService;
    }

    /**
     * @inheritdoc
     */
    public function getAllOrderIds(): array
    {
        $ids = [];
        try {
            $timeStampFilter = Carbon::now()->subDays(30)->getTimestamp();
            $orders = $this->proxy->getOrders((new DateTime)->setTimestamp($timeStampFilter), self::WISH_ORDER_STATE);

            foreach ($orders as $order) {

                if (!$this->isContained($order->getFulfillmentOrderTypes(), $this->fulfillmentStatuses)) {
                    $ids[] = $order->getId();
                }
            }
        } catch (Exception $e) {
            Logger::logWarning('Error occurred while fetching all order IDs: ' . $e->getMessage());
            Logger::logDebug('Error occurred while fetching all order IDs: ' . $e->getTraceAsString());
        }

        return $ids;
    }

    /**
     * @inheritdoc
     */
    public function getOrders(array $batchOrderIds): array
    {
        $orders = [];
        if (empty($batchOrderIds)) {
            return $orders;
        }

        try {
            $timeStampFilter = Carbon::now()->subDays(30)->getTimestamp();
            $wishOrders = $this->proxy->getOrders((new DateTime)->setTimestamp($timeStampFilter), self::WISH_ORDER_STATE);

            if (!$wishOrders) {
                return [];
            }

            foreach ($wishOrders as $wishOrder) {
                $orders[] = $this->transformOrder($wishOrder);
            }
        } catch (Exception $e) {
            Logger::logWarning('Error occurred while fetching all orders by IDs: ' . $e->getMessage());
            Logger::logDebug('Error occurred while fetching all orders by IDs: ' . $e->getTraceAsString());
        }

        return $orders;
    }

    /**
     * @inheritdoc
     */
    public function getOrderById($orderId): ?Order
    {
        try {
            $wishOrder = $this->proxy->getOrderById($orderId);

            return $this->transformOrder($wishOrder);
        } catch (Exception $exception) {
            Logger::logWarning("Order with id $orderId couldn't fetch: {$exception->getMessage()}", 'Integration');
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getOrderByNumber($orderNumber): ?Order
    {
        try {
            $salesOrder = $this->proxy->getOrderById($orderNumber);

            return $salesOrder ? $this->transformOrder($salesOrder) : null;
        } catch (Exception $exception) {
            Logger::logWarning("Order with id $orderNumber couldn't fetch: {$exception->getMessage()}", 'Integration');
        }

        return null;
    }

    /**
     * @inheritdoc
     * @throws HttpRequestException
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws JsonException
     */
    public function updateOrderStatus(Order $order): void
    {
        $parcel = Parcel::fromArray($this->getProxy()->getParcelById($order->getSendCloudParcelId()));
        try {
            if ($order->getSendCloudStatus() === 'Cancelled' || $order->getSendCloudStatus() === 'Cancellation requested') {
                if ($refundReason = $this->refundReasonService->getRefundReason($this->configurationService->getContext())) {
                    $this->refundService->createRefund($parcel, $refundReason);
                }
                return;
            }

            if ($order->getSendCloudStatus() !== 'Announcement failed') {
                $this->shippingService->fulfillOrder($parcel, $order->getId());
            }

        } catch (Exception $e) {
            Logger::logWarning("Failed to update order status: {$e->getMessage()}", 'Integration');
        }
    }

    /**
     * @inheritdoc
     */
    public function orderSyncCompleted(array $orderIds)
    {
        // There is nothing to do when order synchronization is completed.
    }

    /**
     * Transform wish order to sendcloud order
     *
     * @param WishOrder $wishOrder
     * @return Order
     */
    private function transformOrder(WishOrder $wishOrder): Order
    {
        $sendcloudOrder = new Order();

        $sendcloudOrder->setId($wishOrder->getId());
        $sendcloudOrder->setNumber($wishOrder->getId());
        $sendcloudOrder->setCustomerName($wishOrder->getFullAddress()->getShippingDetail()->getName());
        $sendcloudOrder->setCountryCode($wishOrder->getFullAddress()->getShippingDetail()->getCountryCode());
        $sendcloudOrder->setToState($wishOrder->getFullAddress()->getShippingDetail()->getState());
        $sendcloudOrder->setCity($wishOrder->getFullAddress()->getShippingDetail()->getCity());
        $sendcloudOrder->setPostalCode($wishOrder->getFullAddress()->getShippingDetail()->getZipcode());
        $sendcloudOrder->setAddress($wishOrder->getFullAddress()->getShippingDetail()->getStreetAddress1());
        $sendcloudOrder->setAddress2($wishOrder->getFullAddress()->getShippingDetail()->getStreetAddress2());
        $sendcloudOrder->setTelephone($wishOrder->getFullAddress()->getShippingDetail()->getPhoneNumber()->getNumber());
        $product = $this->proxy->getProduct($wishOrder->getProductInformation()->getId());
        $variation = $this->getVariationById($product, $wishOrder->getProductInformation()->getVariationId());
        $sendcloudOrder->setWeight(
            (string)(($variation->getLogisticsDetails()->getWeight() / 1000) * $wishOrder->getOrderPayment()->getGeneralPaymentDetails()->getProductQuantity())
        );
        $sendcloudOrder->setTotalValue(
            (string)($this->getValue($wishOrder) * $wishOrder->getOrderPayment()->getGeneralPaymentDetails()->getProductQuantity())
        );
        $sendcloudOrder->setCustomsInvoiceNr($wishOrder->getId());
        $sendcloudOrder->setCurrency($wishOrder->getOrderPayment()->getGeneralPaymentDetails()->getPaymentTotal()->getCurrencyCode());
        $sendcloudOrder->setUpdatedAt($wishOrder->getUpdatedAt());
        $sendcloudOrder->setStatusId($wishOrder->getState());
        $sendcloudOrder->setStatusName($wishOrder->getState());
        $sendcloudOrder->setItems([$this->transformItems($wishOrder)]);

        return $sendcloudOrder;
    }

    /**
     * @throws HttpRequestException
     * @throws HttpCommunicationException
     * @throws JsonException
     */
    private function transformItems(WishOrder $order): OrderItem
    {
        $sendCloudItem = new OrderItem();
        $product = $this->proxy->getProduct($order->getProductInformation()->getId());
        $variation = $this->getVariationById($product, $order->getProductInformation()->getVariationId());
        $sendCloudItem->setDescription($order->getProductInformation()->getName());
        $sendCloudItem->setHsCode($variation->getLogisticsDetails()->getCustomsHsCode());
        $sendCloudItem->setQuantity($order->getOrderPayment()->getGeneralPaymentDetails()->getProductQuantity());
        $sendCloudItem->setWeight((string)$variation->getLogisticsDetails()->getWeight());
        $sendCloudItem->setOriginCountry($variation->getLogisticsDetails()->getOriginCountry());
        $sendCloudItem->setValue(round($this->getValue($order), 2));
        $sendCloudItem->setSku($order->getProductInformation()->getSku());
        $sendCloudItem->setProductId($order->getProductInformation()->getId());
        $sendCloudItem->setProperties(
            [
                'variation_id' => $order->getProductInformation()->getVariationId(),
                'color' => $order->getProductInformation()->getColor(),
                'size' => $order->getProductInformation()->getSize()
            ]
        );

        return $sendCloudItem;
    }

    /**
     * @param WishOrder $order
     * @return string
     */
    private function getValue(WishOrder $order): string
    {
        return ($order->getOrderPayment()->getGeneralPaymentDetails()->getProductPrice()->getAmount()
            + $order->getOrderPayment()->getGeneralPaymentDetails()->getProductShippingPrice()->getAmount());
    }

    /**
     * @param Product $product
     * @param string $variationId
     * @return Variation|null
     */
    private function getVariationById(Product $product, string $variationId): ?Variation
    {
        foreach ($product->getVariations() as $variation) {
            if ($variation->getId() === $variationId) {
                return $variation;
            }
        }

        return null;
    }

    /**
     * @param array $firstArr
     * @param array $secondArr
     * @return bool
     */
    private function isContained(array $firstArr, array $secondArr): bool
    {
        $response = false;

        foreach ($firstArr as $data) {
            if (in_array($data, $secondArr, true)) {
                $response = true;
            }
        }

        return $response;
    }

    /**
     * Gets proxy class instance.
     *
     * @return Proxy
     */
    private function getProxy(): Proxy
    {
        return ServiceRegister::getService(Proxy::CLASS_NAME);
    }
}
