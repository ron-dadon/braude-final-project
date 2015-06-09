/*
 * Clients New
 */

$(document).on('ready', function() {
    $('#product-type').on('change', function() {
        var current = $(this).val();
        if (current === "software") {
            $("#software-details").removeClass("hidden");
            $("#training-details").addClass("hidden");
        } else {
            $("#software-details").addClass("hidden");
            $("#training-details").removeClass("hidden");
        }
    })
});