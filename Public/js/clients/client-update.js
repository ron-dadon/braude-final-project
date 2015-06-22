/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

/*
 * Clients Update
 */

function deleteContact(id)
{
    $.post(appSettings.homeURI + "/Clients/Contacts/Delete", { delete_id: id } , function(result) {
        result = JSON.parse(result);
        var clientName = result.details.contact;
        $('#confirm-modal').modal('hide');
        if (result.result === true)
        {
            showMessageAlert('<i class="fa fa-fw fa-check-circle"></i>', 'Contact deleted successfully!', 'The client <strong>' + clientName + '</strong> was deleted.', 'success', true);
            $('#contacts-table').bootgrid("remove", [id]);
        }
        else
        {
            showMessageAlert('<i class="fa fa-fw fa-times-circle"></i>', 'Contact deletion failed!', 'The client <strong>' + clientName + '</strong> was not deleted.', 'danger', true);
        }
    });
}

$(document).on('ready', function() {
    $('#contacts-table').bootgrid({
        formatters: {
         "contactActions": function (column, row) {
             return '<button type="button" class="btn btn-xs btn-danger btn-contact-delete" data-delete-id="' + row.id + '" data-delete-name="' + htmlEntities(row.firstName + ' ' + row.lastName) + '"><i class="fa fa-fw fa-trash"></i></button>' +
                    ' <a class="btn btn-xs btn-default" href="' + appSettings.homeURI + '/Clients/Update/' + row.id + '"><i class="fa fa-fw fa-edit"></i></a>';
         }
        }
    }).on('loaded.rs.jquery.bootgrid', function() {
        $('.btn-contact-delete').each(function() {
            $(this).off('click');
            $(this).on('click', function() {
                var deleteId = $(this).data('delete-id');
                $('#confirm-modal-title').html('Delete contact <strong>' + $(this).data('delete-name') + '</strong>');
                $('#confirm-modal-body').html('Are you sure you want to delete the contact <strong>' + $(this).data('delete-name') + '</strong>?<br><small>This action in can not be undone!</small>');
                $('#confirm-button').html('<i class="fa fa-fw fa-trash"></i> Delete').addClass('btn-danger').data('delete-id', deleteId).off('click').on('click', function() { deleteContact($(this).data('delete-id')); });
                $('#confirm-modal').addClass('modal-danger').modal('show');
            });
        })
    });
});