/*
 * Login
 */

$(document).on('ready', function() {
    $('#login-button').on('click', function() {
        $.post("", { user_email: "aaa", user_password: "bbb" }, function(result) {
            console.log(result);
            if (result.result === true)
            {

            }
            else
            {
                alert("Wrong!");
            }
        });
    });
});