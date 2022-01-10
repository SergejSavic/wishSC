(function (document, SendCloud) {
    document.addEventListener("DOMContentLoaded", function () {
        let configurationEndpointUrl = document.getElementById('sc-config-endpoint-url').value;
        let warehouses = document.getElementsByClassName('warehouse-mapping');
        appendEventListeners();
        getConfiguration();

        /**
         * Appends Event Listener to all elements in configuration
         */
        function appendEventListeners() {
            document['configuration'].addEventListener('submit', submit);

            for (let i = 0; i < document['configuration'].elements.length; i++) {
                document['configuration'].elements[i].addEventListener('change', removeValidationClassFromElement);
            }

            document.getElementById('enable-cancellation').addEventListener('change', function () {
                if (document.getElementById('enable-cancellation').checked) {
                    showReturnConfiguration();
                } else {
                    hideReturnConfiguration();
                }
            })
        }

        /**
         * Gets configuration from database
         */
        function getConfiguration() {
            removeValidationClass();
            let url = configurationEndpointUrl;

            SendCloud.Spinner.show();
            SendCloud.Ajax.get(url, null, function (response) {
                if (response) {
                    setFormElements(response);
                    if (response['automaticCancellation'] === true) {
                        document.getElementById('second_configuration').classList.remove('sc-hidden');
                    }
                    SendCloud.Spinner.hide();
                }
            }, 'json', true);
        }

        /**
         * Hides return configuration
         */
        function hideReturnConfiguration() {
            document.getElementById('second_configuration').classList.toggle('sc-hidden', true);
        }

        /**
         * Shows return configuration
         */
        function showReturnConfiguration() {
            document.getElementById('second_configuration').classList.toggle('sc-hidden', false);
        }

        /**
         * Submits form
         *
         * @param event
         */
        function submit(event) {
            event.preventDefault();

            let url = configurationEndpointUrl;

            SendCloud.Spinner.show();
            SendCloud.Ajax.post(url, createConfigTransferObject(), function (response) {
                setFormElements(response);

                SendCloud.Spinner.hide();
            }, 'json', true);
        }

        /**
         * Removes validation class from some elements
         *
         * @param event
         */
        function removeValidationClassFromElement(event) {
            event.target.classList.remove('sc-invalid');
        }

        /**
         * Creates object for sending to Configuration controller
         *
         * @returns {{}}
         */
        function createConfigTransferObject() {
            let inputs = {};

            inputs['cancel'] = null;
            inputs['automaticCancellation'] = false;
            inputs['warehouses'] = {};
            inputs['shipmentType'] = null;
            inputs['country'] = null;
            inputs['hsCode'] = null;
            let arr = {};

            if (document.getElementById('enable-cancellation').checked) {
                inputs['cancel'] = document.getElementById('cancel').value;
                inputs['automaticCancellation'] = true;
            }
            for (let i = 0; i < warehouses.length; i++) {
                arr[warehouses[i].id.toString()] = document.getElementById(warehouses[i].id).value;
            }
            inputs['warehouses'] = JSON.stringify(arr);
            inputs['shipmentType'] = document.getElementById('shipment-type').value;
            inputs['country'] = document.getElementById('country').value;
            inputs['hsCode'] = document.getElementById('hs-code').value;
            console.log(inputs);
            return inputs;
        }

        /**
         * Sets form elements based on server response
         *
         * @param response
         */
        function setFormElements(response) {
            let cancel = document.getElementById('cancel');
            let shipmentType = document.getElementById('shipment-type');
            let country = document.getElementById('country');
            let hsCode = document.getElementById('hs-code');
            let warehouseMapping = JSON.parse(response['warehouses']);

            document.getElementById('enable-cancellation').checked = response['automaticCancellation'];

            if (response['cancel'] !== null && response['cancel'] !== "null") {
                cancel.value = response['cancel'].toString();
            }
            if (response['warehouses'] !== null && response['warehouses'] !== "null") {
                for (let i = 0; i < warehouses.length; i++) {
                    warehouses[i].value = warehouseMapping[warehouses[i].id];
                }
            }
            if (response['shipmentType'] !== null && response['shipmentType'] !== "null") {
                shipmentType.value = response['shipmentType'].toString();
            }
            if (response['country'] !== null && response['country'] !== "null") {
                country.value = response['country'].toString();
            }
            if (response['hsCode'] !== null && response['hsCode'] !== "null") {
                hsCode.value = response['hsCode'].toString();
            }

        }

        /**
         * Removes validation class from all elements in form
         */
        function removeValidationClass() {
            for (let i = 0; i < document['configuration'].elements.length; i++) {
                document['configuration'].elements[i].classList.remove('sc-invalid');
            }
        }
    });
})(document, SendCloud);
