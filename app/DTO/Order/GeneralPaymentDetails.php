<?php

namespace App\DTO\Order;

use App\DTO\AbstractDTO;

/**
 * Class GeneralPaymentDetails
 * @package App\DTO\Order
 */
class GeneralPaymentDetails extends AbstractDTO
{
    /**
     * @var ShippingMerchantPayment
     */
    private ShippingMerchantPayment $shippingMerchantPayment;
    /**
     * @var PaymentTotal
     */
    private PaymentTotal $paymentTotal;
    /**
     * @var ProductPrice
     */
    private ProductPrice $productPrice;
    /**
     * @var ProductMerchantPayment
     */
    private ProductMerchantPayment $productMerchantPayment;
    /**
     * @var ProductShippingPrice
     */
    private ProductShippingPrice $productShippingPrice;
    /**
     * @var int
     */
    private int $productQuantity;

    /**
     * @return ShippingMerchantPayment
     */
    public function getShippingMerchantPayment(): ShippingMerchantPayment
    {
        return $this->shippingMerchantPayment;
    }

    /**
     * @param ShippingMerchantPayment $shippingMerchantPayment
     */
    public function setShippingMerchantPayment(ShippingMerchantPayment $shippingMerchantPayment): void
    {
        $this->shippingMerchantPayment = $shippingMerchantPayment;
    }

    /**
     * @return PaymentTotal
     */
    public function getPaymentTotal(): PaymentTotal
    {
        return $this->paymentTotal;
    }

    /**
     * @param PaymentTotal $paymentTotal
     */
    public function setPaymentTotal(PaymentTotal $paymentTotal): void
    {
        $this->paymentTotal = $paymentTotal;
    }

    /**
     * @return ProductPrice
     */
    public function getProductPrice(): ProductPrice
    {
        return $this->productPrice;
    }

    /**
     * @param ProductPrice $productPrice
     */
    public function setProductPrice(ProductPrice $productPrice): void
    {
        $this->productPrice = $productPrice;
    }

    /**
     * @return ProductMerchantPayment
     */
    public function getProductMerchantPayment(): ProductMerchantPayment
    {
        return $this->productMerchantPayment;
    }

    /**
     * @param ProductMerchantPayment $productMerchantPayment
     */
    public function setProductMerchantPayment(ProductMerchantPayment $productMerchantPayment): void
    {
        $this->productMerchantPayment = $productMerchantPayment;
    }

    /**
     * @return ProductShippingPrice
     */
    public function getProductShippingPrice(): ProductShippingPrice
    {
        return $this->productShippingPrice;
    }

    /**
     * @param ProductShippingPrice $productShippingPrice
     */
    public function setProductShippingPrice(ProductShippingPrice $productShippingPrice): void
    {
        $this->productShippingPrice = $productShippingPrice;
    }

    /**
     * @return int
     */
    public function getProductQuantity(): int
    {
        return $this->productQuantity;
    }

    /**
     * @param int $productQuantity
     */
    public function setProductQuantity(int $productQuantity): void
    {
        $this->productQuantity = $productQuantity;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'shipping_merchant_payment' => $this->shippingMerchantPayment->toArray(),
            'payment_total' => $this->paymentTotal->toArray(),
            'product_price' => $this->productPrice->toArray(),
            'product_merchant_payment' => $this->productMerchantPayment->toArray(),
            'product_shipping_price' => $this->productShippingPrice->toArray(),
            'product_quantity' => $this->productQuantity
        ];
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): GeneralPaymentDetails
    {
        $generalPaymentInfo = new self();
        $generalPaymentInfo->shippingMerchantPayment = ShippingMerchantPayment::fromArray(self::getValue($data, 'shipping_merchant_payment', []));
        $generalPaymentInfo->paymentTotal = PaymentTotal::fromArray(self::getValue($data, 'payment_total', []));
        $generalPaymentInfo->productPrice = ProductPrice::fromArray(self::getValue($data, 'product_price', []));
        $generalPaymentInfo->productMerchantPayment = ProductMerchantPayment::fromArray(self::getValue($data, 'product_merchant_payment', []));
        $generalPaymentInfo->productShippingPrice = ProductShippingPrice::fromArray(self::getValue($data, 'product_shipping_price', []));
        $generalPaymentInfo->productQuantity = self::getValue($data, 'product_quantity');

        return $generalPaymentInfo;
    }
}
