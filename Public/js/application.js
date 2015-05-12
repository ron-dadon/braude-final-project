var autoLogout;

function resetAutoLogout()
{
    clearTimeout(autoLogout);
    autoLogout = setTimeout(function() { $('#auto-logout-modal').modal('show'); }, 1000 * 60 * 60);
}

$(document).on('ready', function() {
    autoLogout = setTimeout(function() { $('#auto-logout-modal').modal('show'); }, 1000 * 60 * 60);
});

$(document).on('mousemove', function(event){
    resetAutoLogout();
});

$(document).on('keypress', function(event){
    resetAutoLogout();
});
