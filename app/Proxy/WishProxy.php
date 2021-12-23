<?php

namespace App\Proxy;

use App\Contracts\Proxy\WishProxyInterface;
use App\Contracts\Services\Auth\WishAuthServiceInterface;
use App\DTO\Order\Order;
use App\DTO\Product\Product;
use App\DTO\Refund\Refund;
use App\DTO\Shipment\Tracking;
use App\DTO\Warehouse\Warehouse;
use DateTime;
use Exception;
use JsonException;
use SendCloud\Infrastructure\Interfaces\Required\HttpClient;
use SendCloud\Infrastructure\Utility\Exceptions\HttpCommunicationException;
use SendCloud\Infrastructure\Utility\Exceptions\HttpRequestException;

class WishProxy extends BaseProxy implements WishProxyInterface
{
    private const LIMIT = 100;

    /**
     * ResourceProxy constructor.
     *
     * @param HttpClient $httpClient
     * @param WishAuthServiceInterface $authService
     */
    public function __construct(
        HttpClient $httpClient,
        WishAuthServiceInterface $authService,
    )
    {
        parent::__construct($httpClient, $authService);
    }

    /**
     * @return Order[]
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws JsonException
     */
    public function getOrders(DateTime $date, string $status): array
    {
        $result = [];

        $parameters = [
            'limit' => self::LIMIT,
            'updated_at_min' => date_format($date, 'Y-m-d\Th:m:s.v+h:m'),
            'states' => $status,
            'sort_by' => 'updated_at.desc'
        ];

        do {
            $iterator = 0;
            $response = $this->get('/orders', $parameters);
            $response = $response['data'];

            foreach ($response as $order) {
                $iterator++;
                /** * this order will be pushed in next iteration after setting updatedAtMax property */
                if ($iterator === self::LIMIT) {
                    break;
                }
                $result[] = Order::fromArray($order);
            }

            if ($iterator === self::LIMIT) {
                $updatedAtMax = $response[self::LIMIT - 1]['updated_at'];
                $parameters['updated_at_max'] = $updatedAtMax;
            }

        } while (count($response) === self::LIMIT);

        return $result;
    }

    /**
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws JsonException
     * @throws Exception
     */
    public function getOrderById(string $id): ?Order
    {
        $response = $this->get('/orders/' . $id, []);

        return !empty($response['data']) ? Order::fromArray($response['data']) : null;
    }

    /**
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws JsonException
     */
    public function updateOrderTracking(Tracking $tracking, string $orderId): void
    {
        $this->put("/orders/$orderId/tracking", $tracking->toArray());
    }

    /**
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws JsonException
     */
    public function createRefund(Refund $refund, string $orderId): void
    {
        $this->put("/orders/$orderId/refund", $refund->toArray());
    }

    /**
     * @return Warehouse[]|null
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws JsonException
     */
    public function getWarehouses(): ?array
    {
        $response = $this->get('/merchant/warehouses', []);

        return !empty($response['data']) ? Warehouse::fromBatch($response['data']) : null;
    }

    /**
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws JsonException
     * @throws Exception
     */
    public function getProduct(string $productId): ?Product
    {
        $response = $this->get('/products/' . $productId, []);

        return !empty($response['data']) ? Product::fromArray($response['data']) : null;
    }

    /**
     * Returns HTTP header
     *
     * @return string[]
     */
    protected function getHeaders(): array
    {
        return [
            'content' => 'Content-Type: application/json',
            'authorization' => 'Authorization: Bearer ' . env('TOKEN')
        ];
    }
}
