/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

/*
 * Administration settings
 */

$(document).on('ready', function() {
    $('#security-idle-logout').on('change', function() {
        if ($(this).val() == 1)
        {
            $('#security-idle-logout-time').prop('disabled', false);
        }
        else
        {
            $('#security-idle-logout-time').prop('disabled', true);
        }
    });
    $('#save-button').on('click', function() {
        $('#settings-form').submit();
    });
    $('#save-button-xs').on('click', function() {
        $('#settings-form').submit();
    });
    $('#settings-form').validator().on('submit', function(e) {
        if (e.isDefaultPrevented())
        {
            showMessageAlert('<i class="fa fa-fw fa-2x fa-times-circle"></i>', 'Failed to save settings!', 'One or more of your settings are invalid. Please try again.', 'danger', true);
        }
        else
        {
            $('#save-button').html('<i class="fa fa-fw fa-spin fa-spinner"></i> Saving...').prop('disabled', true);
            var postData = {
                securityAllowIdle: $('#security-idle-logout').val(),
                securityIdleTime: $('#security-idle-logout-time').val(),
                securityAllowReset: $('#security-password-reset').val(),
                emailHost: $('#email-host').val(),
                emailPort: $('#email-port').val(),
                emailSecurity: $('#email-security').val(),
                emailUser: $('#email-user').val(),
                emailPassword: $('#email-password').val(),
                tax: $('#general-tax').val()
            };
            $.post("", postData , function(result) {
                result = JSON.parse(result);
                if (result.result === true)
                {
                    showMessageAlert('<i class="fa fa-fw fa-2x fa-check-circle"></i>', 'Settings saved successfully!', 'Your settings were updated.', 'success', true);
                }
                else
                {
                    showMessageAlert('<i class="fa fa-fw fa-2x fa-times-circle"></i>', 'Failed to save settings!', 'Your settings were not updated.', 'danger', true);
                }
                $('#save-button').html('<i class="fa fa-fw fa-check"></i> Save').prop('disabled', false);
            });
        }
        return false;
    });
});