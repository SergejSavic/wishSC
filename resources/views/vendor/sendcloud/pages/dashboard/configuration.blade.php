<input id="sc-config-endpoint-url" type="hidden" name="scConfigEndpointUrl" value="{{$configuration_url}}"/>
<div class="sc-content-window" data-tab-id="1">
    <form name="configuration" novalidate class="sc-form">
        <h3>{{__('wish.configure.warehouse.mapping.title')}}</h3>
        <p>{{__('wish.configure.warehouse.mapping.description')}}</p>
        <div class="sc-warehouse-wrapper sc-form-group-wrapper">
            <div class="sc-form-row">
                <label for="sender-address">
                    {{__('wish.configure.warehouse.mapping.label')}}:
                </label>
                <select name="senderAddress" id="sender-address" required>
                    @foreach($senderAddresses as $senderAddress)
                        <option value="{{$senderAddress['value']}}">{{$senderAddress['label']}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <h3>{{__('wish.configure.international.shipping.mapping.title')}}</h3>
        <p>{{__('wish.configure.international.shipping.mapping.description')}}</p>
        <div class="sc-warehouse-wrapper sc-form-group-wrapper">
            <div class="sc-form-row">
                <label for="shipment-type">
                    {{__('wish.configure.international.shipping.mapping.shipment_type.label')}}:
                </label>
                <select name="shipmentType" id="shipment-type" required>
                    @foreach($senderAddresses as $senderAddress)
                        <option value="{{$senderAddress['value']}}">{{$senderAddress['label']}}</option>
                    @endforeach
                </select>
            </div>

            <div class="sc-form-row">
                <label for="country">
                    {{__('wish.configure.international.shipping.mapping.country.label')}}:
                </label>
                <select name="country" id="country" required>
                    @foreach($senderAddresses as $senderAddress)
                        <option value="{{$senderAddress['value']}}">{{$senderAddress['label']}}</option>
                    @endforeach
                </select>
            </div>

            <div class="sc-form-row">
                <label for="hs-code">
                    {{__('wish.configure.international.shipping.mapping.hs_code.label')}}:
                </label>
                <input name="hsCode" id="hs-code"/>
            </div>
        </div>

        <h3>{{__('wish.configuration.enable.automatic.cancellation.title')}}</h3>
        <p>{{__('wish.configuration.enable.automatic.cancellation.description')}}</p>
        <div class="sc-location-wrapper sc-form-group-wrapper">
            <div class="sc-form-row">
                <label class="sc-checkbox-container"
                       for="enable-cancellation">{{__('wish.configuration.enable.automatic.cancellation.label')}}
                    :</label>
                <input type="checkbox" name="automaticCancellation" id="enable-cancellation">

            </div>
        </div>

        <div id="second_configuration" class="sc-hidden">
            <h3>{{__('wish.configure.return.type.title')}}</h3>
            <p>{{__('wish.configure.cancel.type.description')}}</p>
            <div class="sc-warehouse-wrapper sc-form-group-wrapper">
                <div class="sc-form-row">
                    <label for="refund">
                        {{__('wish.configure.return.type.label')}}:
                    </label>
                    <select name="refund" id="refund" required>
                        <option value="{{$refundReason['code']}}">{{$refundReason['label']}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="sc-form-actions-wrapper">
            <button type="submit">{{__('wish.configuration.save')}}</button>
        </div>
    </form>
</div>

<div id="sc-config-spinner" class="sc-loading-overlay-container">
    <div class="sc-loading-overlay"></div>
</div>
<script src="{{\SendCloud\MiddlewareComponents\Utility\Asset::getAssetUrl('js/sendcloud.ajax.js')}}"
        type="text/javascript"></script>
<script src="{{\SendCloud\MiddlewareComponents\Utility\Asset::getAssetUrl('js/sendcloud.spinner.js')}}"
        type="text/javascript"></script>
<script src="{{\SendCloud\MiddlewareComponents\Utility\Asset::getAssetUrl('js/sendcloud.configuration.js')}}"
        type="text/javascript"></script>

