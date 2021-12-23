<?php

namespace App\DTO\Order;

use App\DTO\AbstractDTO;
use DateTime;
use Exception;

/**
 * Class FulfillmentRequirements
 * @package App\DTO\Order
 */
class FulfillmentRequirements extends AbstractDTO
{
    /**
     * @var DateTime
     */
    private DateTime $expectedShipTime;
    /**
     * @var DateTime
     */
    private DateTime $expectedDeliveryTime;

    /**
     * @return DateTime
     */
    public function getExpectedShipTime(): DateTime
    {
        return $this->expectedShipTime;
    }

    /**
     * @param DateTime $expectedShipTime
     */
    public function setExpectedShipTime(DateTime $expectedShipTime): void
    {
        $this->expectedShipTime = $expectedShipTime;
    }

    /**
     * @return DateTime
     */
    public function getExpectedDeliveryTime(): DateTime
    {
        return $this->expectedDeliveryTime;
    }

    /**
     * @param DateTime $expectedDeliveryTime
     */
    public function setExpectedDeliveryTime(DateTime $expectedDeliveryTime): void
    {
        $this->expectedDeliveryTime = $expectedDeliveryTime;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'expected_ship_time' => $this->expectedShipTime,
            'expected_delivery_time' => $this->expectedDeliveryTime
        ];
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    public static function fromArray(array $data): FulfillmentRequirements
    {
        $fulfillmentRequirements = new self();
        $fulfillmentRequirements->expectedShipTime = new DateTime(self::getValue($data, 'expected_ship_time'));
        $fulfillmentRequirements->expectedDeliveryTime = new DateTime(self::getValue($data, 'expected_delivery_time'));

        return $fulfillmentRequirements;
    }
}
