<?php
return [
    'configure.warehouse.mapping.title' => 'Configure warehouse mapping',
    'configure.warehouse.mapping.description' => 'Map Wish warehouse to Sendcloud sender addresses. If mapping is not set, the integration will use default sender address defined
    in Sendcloud under Settings > Addresses > Sender Address.',
    'configure.warehouse.mapping.label' => 'STANDARD',

    'configure.international.shipping.mapping.title' => 'Configure international shipping mapping',
    'configure.international.shipping.mapping.description' => 'To send international shipment data to Sendcloud, please select a default value which will be used',
    'configure.international.shipping.mapping.shipment_type.label' => 'Shipment type',
    'configure.international.shipping.mapping.country.label' => 'Country',
    'configure.international.shipping.mapping.hs_code.label' => 'HS code',

    'configuration.enable.automatic.cancellation.title' => 'Enable order cancellation',
    'configuration.enable.automatic.cancellation.description' => 'By enabling this option the integration will create refund in Wish automatically when parcel is cancelled in Sendcloud',
    'configuration.enable.automatic.cancellation.label' => 'Enable order cancellation',

    'configuration.enable.return.title' => 'Enable return synchronization',
    'configuration.enable.return.description' => 'By enabling this option the integration will create refund in Wish automatically when a return is created in Sendcloud',
    'configuration.enable.return.label' => 'Enable returns',

    'configure.return.type.title' => 'Configure default refund reason',
    'configure.cancel.type.description' => 'Select the default refund reason that will be used when a parcel is cancelled in Sendcloud. If not set, refund won\'t be created.',
    'configure.return.type.description' => 'Select the default refund values that will be used when a return is created in Sendcloud. If not set, refund won\'t be created.',
    'configure.return.type.label' => 'Refund reason',

    'configuration.save' => 'Save',

    'connect.title' => 'Connect with Wish',
    'login.btn.label' => 'Sign in with Wish',

    'errors.internal_error' => 'Internal Server Error',
    'errors.bad_request' => 'Bad Request',
    'errors.not_found' => 'Not Found',
    'errors.forbidden' => 'Forbidden',
    'errors.unauthorized' => 'Unauthorized',
];
