/*
 * Login
 */

function clearAlert()
{
    $('#login-alert').addClass('hidden');
}

$(document).on('ready', function() {
    $('#user-email').on('keypress', clearAlert).on('change', clearAlert);
    $('#user-password').on('keypress', clearAlert).on('change', clearAlert);
    $('#login-button').on('click', function() {
        var email = $('#user-email').val();
        var password = $('#user-password').val();
        $.post("", { user_email: email, user_password: password }, function(result) {
            result = JSON.parse(result);
            if (result.result === true)
            {
                $('#login-form').hide();
                $('#login-alert').removeClass('hidden alert-danger').addClass('alert-success');
                $('#alert-title').html("התחברת בהצלחה!");
                $('#alert-text').html("<i class=\"fa fa-spinner fa-spin\"></i> הנך מועבר למערכת בשניות הקרובות...");
                setTimeout(function() { window.location.href = appSettings.homeURI }, 2000);
            }
            else
            {
                $('#login-alert').removeClass('hidden');
                $('#alert-title').html("ההתחברות נכשלה!");
                $('#alert-text').html("שם המשתמש ו/או הסיסמא שגויים. אנא נסה שנית.");
                $('#user-email').focus().select();
            }
        });
    });
});