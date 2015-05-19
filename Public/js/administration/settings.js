/*
 * Administration index
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
    $('#settings-form').validator().on('submit', function(e) {
        if (e.isDefaultPrevented())
        {
            $('#message-modal-title').html('<i class="fa fa-fw fa-times"></i> Your settings contain errors!');
            $('#message-modal-body').html('Please check for red marked fields and fix the errors. This message will be closed within 3 seconds.');
            $('#message-modal-button').removeClass('btn-success').addClass('btn-danger');
            $('#message-modal').removeClass('modal-success').addClass('modal-danger').modal('show');
            setTimeout(function() { $('#message-modal').modal('hide'); }, 3000);
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
                emailPassword: $('#email-password').val()
            };
            $.post("", postData , function(result) {
                console.log(result);
                result = JSON.parse(result);
                if (result.result === true)
                {
                    $('#message-modal-title').html('<i class="fa fa-fw fa-check"></i> Settings saved successfully!');
                    $('#message-modal-body').html('Your settings were updated.<br><small>This message will be closed within 3 seconds...</small>');
                    $('#message-modal-button').removeClass('btn-danger').addClass('btn-success');
                    $('#message-modal').removeClass('modal-danger').addClass('modal-success').modal('show');
                }
                else
                {
                    $('#message-modal-title').html('<i class="fa fa-fw fa-times"></i> Error saving settings!');
                    $('#message-modal-body').html('Your settings were not updated.<br><small>This message will be closed within 3 seconds...</small>');
                    $('#message-modal-button').removeClass('btn-success').addClass('btn-danger');
                    $('#message-modal').removeClass('modal-success').addClass('modal-danger').modal('show');
                }
                setTimeout(function() { $('#message-modal').modal('hide'); }, 3000);
                $('#save-button').html('<i class="fa fa-fw fa-check"></i> Save').prop('disabled', false);
            });
        }
        return false;
    });
});