/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

/*
 * Invoices Show
 */

function showMailingModal(id, mail)
{
    showMessageModal('<i class="fa fa-fw fa-send"></i>', 'Sending invoice...', '<i class="fa fa-fw fa-spin fa-spinner"></i> Sending invoice to <strong>' + mail + '</strong>...please wait...', 'main', false);
    $.get(appSettings.homeURI + "/Invoices/Mail/" + id , function(data) {
        if (data === '1') {
            showMessageModal('<i class="fa fa-fw fa-check-circle"></i>', 'Invoice sent', 'Invoice sent to ' + mail, 'success', true);
        } else {
            showMessageModal('<i class="fa fa-fw fa-times-circle"></i>', 'Invoice was not sent', 'Error sending invoice: ' + data, 'danger', true);
        }
    });
}

$(document).on('ready', function() {
    $('.send-mail-btn').each(function() {
        var id = $(this).data('send-id');
        var mail = $(this).data('send-email');
        $(this).on('click', function() {
            showMailingModal(id, mail);
        })
    })
});