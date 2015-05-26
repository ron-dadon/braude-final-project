var autoLogoutTimer = null;
var lastReset = 0;

function addslashes( str ) {
    return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function autoLogout()
{
    clearTimeout(autoLogoutTimer);
    autoLogoutTimer = false;
    $.get(appSettings.homeURI + "/Logout", {}, function(result) {
        if (result.substr(0,2) === "OK")
        {
            $(document)
                .unbind('mousemove')
                .unbind('keydown')
                .unbind('DOMMouseScroll')
                .unbind('mousewheel')
                .unbind('mousedown');
            $('#auto-logout-modal').modal('show');
        }
    });
}

function resetAutoLogout()
{
    if (autoLogoutTimer !== false && lastReset === 0)
    {
        clearTimeout(autoLogoutTimer);
        lastReset = 200;
        autoLogoutTimer = setTimeout(autoLogout, 1000 * 60 * appSettings.autoLogoutTime);
    }
    lastReset--;
}

$(document).on('ready', function() {
    // Bind actions to reset auto logout
    $(document)
        .bind('mousemove', resetAutoLogout)
        .bind('keydown', resetAutoLogout)
        .bind('DOMMouseScroll', resetAutoLogout)
        .bind('mousewheel', resetAutoLogout)
        .bind('mousedown', resetAutoLogout);
    var alerts = $('.alert-dismissable');
    if (alerts.length > 0)
    {
        setTimeout(function() { alerts.alert('close'); }, 3000);
    }
});

function showMessageModal(titleIcon, msgTitle, msgBody, type, autoHide)
{
    $('#message-modal-title').html(titleIcon + ' ' + msgTitle);
    $('#message-modal-body').html(msgBody + (autoHide ? '<br><small>This message will be closed within 3 seconds...</small>' : ''));
    if (type === 'success')
    {
        $('#message-modal-button').removeClass('btn-danger').addClass('btn-success');
        $('#message-modal').removeClass('modal-danger').addClass('modal-success').modal('show');
    }
    else
    {
        $('#message-modal-button').removeClass('btn-success').addClass('btn-danger');
        $('#message-modal').removeClass('modal-success').addClass('modal-danger').modal('show');
    }
    if (autoHide)
    {
        setTimeout(function() { $('#message-modal').modal('hide'); }, appSettings.messageDismissTime);
    }
}

function showMessageAlert(titleIcon, msgTitle, msgBody, type, autoHide)
{
    var container = $('#alerts-container');
    container.append('<div class="alert alert-dismissable alert-' + type + ' fade in"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><div class="media no-margin no-padding"><div class="media-left">' + titleIcon + '</div><div class="media-body"><h4>' + msgTitle + '</h4>' + msgBody + '</div></div></div>');
    if (autoHide)
    {
        setTimeout(function() { $('.alert-dismissable').alert('close'); }, appSettings.messageDismissTime);
    }
}