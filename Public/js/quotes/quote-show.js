/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

/*
 * Quotes Show
 */

function showMailingModal(id, mail)
{
    showMessageModal('<i class="fa fa-fw fa-send"></i>', 'Sending quote...', '<i class="fa fa-fw fa-spin fa-spinner"></i> Sending quote to ' + mail + '...please wait...', 'main', false);
    $.get(appSettings.homeURI + "/Quotes/Mail/" + id , function(data) {
        if (data === '1') {
            showMessageModal('<i class="fa fa-fw fa-check-circle"></i>', 'Quote sent', 'Quote sent to ' + mail, 'success', true);
        } else {
            showMessageModal('<i class="fa fa-fw fa-times-circle"></i>', 'Quote was not sent', 'Error sending quote: ' + data, 'danger', true);
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