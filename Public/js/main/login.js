/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

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
        clearAlert();
        var email = $('#user-email').val();
        var password = $('#user-password').val();
        $.post("", { user_email: email, user_password: password }, function(result) {
            result = JSON.parse(result);
            if (result.result === true)
            {
                $('#login-form').hide();
                $('#login-footer').hide();
                $('#login-alert').removeClass('hidden alert-danger').addClass('alert-success');
                $('#alert-title').html("Logged in successfully!");
                $('#alert-text').html('<i class="fa fa-spinner fa-spin"></i> You are redirected...');
                setTimeout(function() { window.location.href = appSettings.homeURI }, 2000);
            }
            else
            {
                $('#login-alert').removeClass('hidden');
                $('#alert-title').html("Login failed!");
                $('#alert-text').html("User or password are wrong. Please try again.");
                $('#user-email').focus().select();
            }
        });
    });
});