(function (document, SendCloud) {
    document.addEventListener("DOMContentLoaded", function () {
        let configurationEndpointUrl = document.getElementById('sc-config-endpoint-url').value;
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
                    SendCloud.Spinner.hide();
                }
            }, 'json', true);
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

            inputs['refund'] = null;
            inputs['automaticCancellation'] = false;
            inputs['senderAddress'] = null;
            inputs['shipmentType'] = null;
            inputs['country'] = null;
            inputs['hsCode'] = null;

            if (document.getElementById('enable-cancellation').checked) {
                inputs['refund'] = document.getElementById('refund').value;
                inputs['automaticCancellation'] = true;
            }

            inputs['senderAddress'] = document.getElementById('sender-address').value;
            inputs['shipmentType'] = document.getElementById('shipment-type').value;
            inputs['country'] = document.getElementById('country').value;
            inputs['hsCode'] = document.getElementById('hs-code').value;

            return inputs;
        }

        /**
         * Sets form elements based on server response
         *
         * @param response
         */
        function setFormElements(response) {
            let refund = document.getElementById('refund');
            let senderAddress = document.getElementById('sender-address');
            let shipmentType = document.getElementById('shipment-type');
            let country = document.getElementById('country');
            let hsCode = document.getElementById('hs-code');

            document.getElementById('enable-cancellation').checked = response['automaticCancellation'];

            if (response['refund'] !== null && response['refund'] !== "null") {
                refund.value = response['refund'].toString();
            }
            if (response['senderAddress'] !== null && response['senderAddress'] !== "null") {
                senderAddress.value = response['senderAddress'].toString();
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