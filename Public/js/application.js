var autoLogout;

function resetAutoLogout()
{
    clearTimeout(autoLogout);
    autoLogout = setTimeout(function() { $('#auto-logout-modal').modal('show'); }, 5000);
}

$(document).on('ready', function() {
    autoLogout = setTimeout(function() { $('#auto-logout-modal').modal('show'); }, 5000);
});

$(document).on('mousemove', function(event){
    resetAutoLogout();
});

$(document).on('keypress', function(event){
    resetAutoLogout();
});
