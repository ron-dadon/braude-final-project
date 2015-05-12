var autoLogout;
$(document).on('ready', function() {
    autoLogout = setTimeout(function() { $('#auto-logout-modal').modal('show'); }, 5000);
});
$(document).on('mousemove', function(event){
    clearTimeout(autoLogout);
    autoLogout = setTimeout(function() { $('#auto-logout-modal').modal('show'); }, 5000);
});
