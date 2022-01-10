<?php

namespace App\Contracts\Orders\Carriers;

interface CarrierNamesInterface
{
    /**
     * Sendcloud carrier code is key, Wish carrier name is value
     */
    public const WISH_CARRIERS_NAME_MAPPING = [
        'postat' => 'AustrianPost',
        'bpost' => 'BPost',
        'colisprive' => 'ColisPrive',
        'colissimo' => 'Colissimo',
        'correos' => 'CorreosDeEspana',
        'correos_express' => 'CorreosExpress',
        'dp' => 'DeutschePost',
        'dhl' => 'DHL',
        'dhl_express' => 'DHL',
        'dhl_de' => 'DHLGermany',
        'dpd' => 'DPD',
        'gls_de' => 'GLS',
        'gls_it' => 'GLS Italy',
        'postnl' => 'PostNL',
        'poste_italiane' => 'PosteItaliane',
        'ups' => 'UPS'
    ];
}
