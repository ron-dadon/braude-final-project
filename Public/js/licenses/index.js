/*
 * Licenses Index
 */
function deleteLicense(id)
{
    $.post(appSettings.homeURI + "/Licenses/Delete", { delete_id: id } , function(result) {
        result = JSON.parse(result);
        var serial = result.details.license;
        $('#confirm-modal').modal('hide');
        if (result.result === true)
        {
            showMessageAlert('<i class="fa fa-fw fa-check-circle"></i>', 'License deleted successfully!', 'The license <strong>' + serial + '</strong> was deleted.', 'success', true);
            $('#licenses-table').bootgrid("remove", [id]);
        }
        else
        {
            showMessageAlert('<i class="fa fa-fw fa-times-circle"></i>', 'License deletion failed!', 'The license <strong>' + serial + '</strong> was not deleted.', 'danger', true);
        }
    });
}

$(document).on('ready', function() {
    $('#licenses-table').bootgrid({
       formatters: {
           "licenseLink": function (column, row) {
               return '<a href="' + appSettings.homeURI + '/Licenses/Show/' + row.licenseId + '">' + row.serial + '</a>';
           },
           "licenseActions": function (column, row) {
               return '<button class="btn btn-xs btn-danger btn-license-delete" data-delete-id="' + row.licenseId + '" data-delete-name="' + htmlEntities(row.serial) + '"><i class="fa fa-fw fa-trash"></i></button>' +
                      ' <a class="btn btn-xs btn-default" href="' + appSettings.homeURI + '/Licenses/Update/' + row.licenseId + '"><i class="fa fa-fw fa-edit"></i></a>';
           }
       }
   }).on('loaded.rs.jquery.bootgrid', function() {
        $('.btn-license-delete').each(function() {
            $(this).off('click');
            $(this).on('click', function() {
                var deleteId = $(this).data('delete-id');
                $('#confirm-modal-title').html('Delete license <strong>' + $(this).data('delete-name') + '</strong>');
                $('#confirm-modal-body').html('Are you sure you want to delete the license <strong>' + $(this).data('delete-name') + '</strong>?<br><small>This action in can not be undone!</small>');
                $('#confirm-button').html('<i class="fa fa-fw fa-trash"></i> Delete').addClass('btn-danger').data('delete-id', deleteId).off('click').on('click', function() { deleteClient($(this).data('delete-id')); });
                $('#confirm-modal').addClass('modal-danger').modal('show');
            });
        })
    });

});