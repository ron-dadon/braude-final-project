/*
 * Clients Index
 */
function deleteClient(id)
{
    $.post(appSettings.homeURI + "/Clients/Delete", { delete_id: id } , function(result) {
        console.log(result);
        result = JSON.parse(result);
        var clientName = result.details.client;
        $('#confirm-modal').modal('hide');
        if (result.result === true)
        {
            showMessageAlert('<i class="fa fa-fw fa-check-circle"></i>', 'Client deleted successfully!', 'The client <strong>' + clientName + '</strong> was deleted.', 'success', true);
            $('#clients-table').bootgrid("remove", [id]);
        }
        else
        {
            showMessageAlert('<i class="fa fa-fw fa-times-circle"></i>', 'Client deletion failed!', 'The client <strong>' + clientName + '</strong> was not deleted.', 'danger', true);
        }
    });
}

$(document).on('ready', function() {
    $('#clients-table').bootgrid({
       formatters: {
           "webLink": function (column, row) {
               return '<a href="' + row.website + '" target="_blank">' + row.website + '</a>';
           },
           "telLink": function (column, row) {
               return '<a class="visible-xs" href="tel:' + row.phone + '">' + row.phone + '</a><span class="hidden-xs">' + row.phone + '</span>';
           },
           "emailLink": function (column, row) {
               return '<a href="mailto:' + row.email + '">' + row.email + '</a>';
           },
           "addressLink": function (column, row) {
               return '<a  class="visible-xs" href="waze://?q=' + row.address + '">' + row.address + '</a><span class="hidden-xs">' + row.address + '</span>';
           },
           "clientActions": function (column, row) {
               return '<button class="btn btn-xs btn-danger btn-client-delete" data-delete-id="' + row.id + '" data-delete-name="' + row.clientName + '"><i class="fa fa-fw fa-trash"></i></button>' +
                      ' <a class="btn btn-xs btn-default" href="' + appSettings.homeURI + '/Clients/Update/' + row.id + '"><i class="fa fa-fw fa-edit"></i></a>';
           }
       }
   }).on('loaded.rs.jquery.bootgrid', function() {
        $('.btn-client-delete').each(function() {
            $(this).off('click');
            $(this).on('click', function() {
                var deleteId = $(this).data('delete-id');
                $('#confirm-modal-title').html('Delete client <strong>' + $(this).data('delete-name') + '</strong>');
                $('#confirm-modal-body').html('Are you sure you want to delete the client <strong>' + $(this).data('delete-name') + '</strong>?<br><small>This action in can not be undone!</small>');
                $('#confirm-button').html('<i class="fa fa-fw fa-trash"></i> Delete').addClass('btn-danger').data('delete-id', deleteId).off('click').on('click', function() { deleteClient($(this).data('delete-id')); });
                $('#confirm-modal').addClass('modal-danger').modal('show');
            });
        })
    });
});