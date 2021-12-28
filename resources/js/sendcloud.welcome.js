(function () {
    document.addEventListener("DOMContentLoaded", function () {
        var button = document.getElementById('sc-log-to-account'),
            authUrl = document.getElementById('sc-connect-url');

        if (button && authUrl) {
            button.addEventListener('click', function () {
                location.href = authUrl.value;
                ``            });
        }

    });
})();
