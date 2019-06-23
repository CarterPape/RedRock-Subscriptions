(function($) {
    function cleanedZipCode() {
        var zipRegex = /^\d{5}$/g;
        var zipCode = document
            .getElementById("zip-code-input")
                .value
                    .match(zipRegex);
        return zipCode ? zipCode[0] : null;
    }

    $("#zip-code-form").submit(function(event) {
        event.preventDefault();
        var zip = cleanedZipCode();
        if (zip === null) {
            $("#zip-form-error-text")
                .removeClass("hidden");
        }
        else {
            switch (zip) {
                case "84534":
                case "84512":
                case "84531":
                case "84536":
                case "84533":
                case "84511":
                case "84535":
                case "84530":
                case "84532":
                case "84540":
                case "84525":
                    window.location.href = "/subscriptions/local/";
                    break;
                default:
                    window.location.href = "/subscriptions/out-of-town/";
                    break;
            }
        }
    });
})(jQuery);