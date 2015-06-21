/*
 * Products Update
 */

$(document).on('ready', function() {
    $('#product-type').on('change', function() {
        var current = $(this).val();
        if (current === "software") {
            $("#software-details").removeClass("hidden");
            $("#training-details").addClass("hidden");
        } else {
            $('#product-manufactor').val('iacs');
            $("#software-details").addClass("hidden");
            $("#training-details").removeClass("hidden");
        }
    });
    $('#product-manufactor').on('change', function() {
        var current = $(this).val();
        if (current === "caseware" && $('#product-type').val() == 'training') {
            $(this).val('iacs');
        }
    });
});