/*
 * Administration users
 */

function deleteUser(id)
{
    $.post(appSettings.homeURI + "/Administration/Users/Delete", { delete_id: id } , function(result) {
        result = JSON.parse(result);
        var userName = result.details.user;
        $('#confirm-modal').modal('hide');
        if (result.result === true)
        {
            showMessageAlert('<i class="fa fa-fw fa-check-circle"></i>', 'User deleted successfully!', 'The user <strong>' + userName + '</strong> was deleted.', 'success', true);
            $('#users-table').bootgrid("remove", [id]);
        }
        else
        {
            showMessageAlert('<i class="fa fa-fw fa-times-circle"></i>', 'User deletion failed!', 'The user <strong>' + userName + '</strong> was not deleted.', 'danger', true);
        }
    });
}

$(document).on('ready', function() {
    $('#users-table').bootgrid({
        formatters: {
            "userActions": function (column, row) {
                return '<button class="btn btn-xs btn-danger btn-user-delete" data-delete-id="' + row.id + '" data-delete-name="' + row.firstName + ' ' + row.lastName + '"><i class="fa fa-fw fa-trash"></i></button>' +
                ' <a class="btn btn-xs btn-default" href="' + appSettings.homeURI + '/Administration/Users/Update/' + row.id + '"><i class="fa fa-fw fa-edit"></i></a>';
            }
        }
    }).on('loaded.rs.jquery.bootgrid', function() {
        $('.btn-user-delete').each(function() {
            $(this).off('click');
            $(this).on('click', function() {
                var deleteId = $(this).data('delete-id');
                $('#confirm-modal-title').html('Delete user <strong>' + $(this).data('delete-name') + '</strong>');
                $('#confirm-modal-body').html('Are you sure you want to delete the user <strong>' + $(this).data('delete-name') + '</strong>?<br><small>This action in can not be undone!</small>');
                $('#confirm-button').html('<i class="fa fa-fw fa-trash"></i> Delete').addClass('btn-danger').data('delete-id', deleteId).off('click').on('click', function() { deleteUser($(this).data('delete-id')); });
                $('#confirm-modal').addClass('modal-danger').modal('show');
            });
        })
    });

});