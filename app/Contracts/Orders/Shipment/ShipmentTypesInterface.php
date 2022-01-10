<?php

namespace App\Contracts\Orders\Shipment;

interface ShipmentTypesInterface
{
    public const SHIPMENT_TYPE_PRESELECTED_VALUE = 2;

    public const SHIPMENT_TYPES = [
        [
            'value' => 0,
            'label' => 'Gifts'
        ],
        [
            'value' => 1,
            'label' => 'Documents'
        ],
        [
            'value' => 2,
            'label' => 'Commercial goods'
        ],
        [
            'value' => 3,
            'label' => 'Commercial sample'
        ],
        [
            'value' => 4,
            'label' => 'Returned goods'
        ],
    ];
}
