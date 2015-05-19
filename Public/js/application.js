var autoLogoutTimer = null;
var lastReset = 0;

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
});