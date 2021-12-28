var SendCloud = SendCloud || {};

(function () {

    var spinner = {

        /**
         * Hides/Shows loading spinner
         *
         * @param {boolean} showSpinner
         */
        changeSpinner: function (showSpinner) {
            let spinnerElement = document.querySelector('#sc-config-spinner');
            if (spinnerElement) {
                spinnerElement.style.display = showSpinner ? 'flex' : 'none';
            }
        },

        /**
         * Shows loading spinner
         */
        show: function () {
            spinner.changeSpinner(true);
        },

        /**
         * Hides loading spinner
         */
        hide: function () {
            spinner.changeSpinner(false);
        }
    };

    /**
     * Spinner component
     *
     * @type {{changeSpinner: spinner.changeSpinner, show: spinner.show, hide: spinner.hide}}
     */
    SendCloud.Spinner = spinner;
})();
