/*
 * Clients Index
 */
String.prototype.pad = function(padString, length) {
    var str = this;
    while (str.length < length)
        str = padString + str;
    return str;
};

function deleteQuote(id)
{
    $.post(appSettings.homeURI + "/Quotes/Delete", { delete_id: id } , function(result) {
        console.log(result);
        result = JSON.parse(result);
        var quoteName = result.details.quote;
        $('#confirm-modal').modal('hide');
        if (result.result === true)
        {
            showMessageAlert('<i class="fa fa-fw fa-check-circle"></i>', 'Quote deleted successfully!', 'The quote <strong>' + quoteName + '</strong> was deleted.', 'success', true);
            $('#quotes-table').bootgrid("remove", [id]);
        }
        else
        {
            showMessageAlert('<i class="fa fa-fw fa-times-circle"></i>', 'Quote deletion failed!', 'The quote <strong>' + quoteName + '</strong> was not deleted.', 'danger', true);
        }
    });
}

$(document).on('ready', function() {
    $('#quotes-table').bootgrid({
       formatters: {
           "quoteLink": function (column, row) {
               return '<a href="' + appSettings.homeURI + '/Quotes/Show/' + row.id + '">' + row.id.pad("0",8) + '</a>';
           },
           "quoteActions": function (column, row) {
               return '<button class="btn btn-xs btn-danger btn-quote-delete" data-delete-id="' + row.id + '" data-delete-name="' + htmlEntities(row.id.pad("0", 8)) + '"><i class="fa fa-fw fa-trash"></i></button>' +
                      ' <a class="btn btn-xs btn-default" href="' + appSettings.homeURI + '/Quotes/Update/' + row.id + '"><i class="fa fa-fw fa-edit"></i></a>';
           }
       }
   }).on('loaded.rs.jquery.bootgrid', function() {
        $('.btn-quote-delete').each(function() {
            $(this).off('click');
            $(this).on('click', function() {
                var deleteId = $(this).data('delete-id');
                $('#confirm-modal-title').html('Delete quote <strong>' + $(this).data('delete-name') + '</strong>');
                $('#confirm-modal-body').html('Are you sure you want to delete the quote <strong>' + $(this).data('delete-name') + '</strong>?<br><small>This action in can not be undone!</small>');
                $('#confirm-button').html('<i class="fa fa-fw fa-trash"></i> Delete').addClass('btn-danger').data('delete-id', deleteId).off('click').on('click', function() { deleteQuote($(this).data('delete-id')); });
                $('#confirm-modal').addClass('modal-danger').modal('show');
            });
        })
    });
});