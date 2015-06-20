/*
 * Invoices Index
 */

String.prototype.pad = function(padString, length) {
    var str = this;
    while (str.length < length)
        str = padString + str;
    return str;
};

function deleteInvoice(id)
{
    $.post(appSettings.homeURI + "/Invoices/Delete", { delete_id: id } , function(result) {
        console.log(result);
        result = JSON.parse(result);
        var invoiceName = result.details.invoice;
        $('#confirm-modal').modal('hide');
        if (result.result === true)
        {
            showMessageAlert('<i class="fa fa-fw fa-check-circle"></i>', 'Invoice deleted successfully!', 'The invoice <strong>' + invoiceName + '</strong> was deleted.', 'success', true);
            $('#invoices-table').bootgrid("remove", [id]);
        }
        else
        {
            showMessageAlert('<i class="fa fa-fw fa-times-circle"></i>', 'Invoice deletion failed!', 'The invoice <strong>' + invoiceName + '</strong> was not deleted.', 'danger', true);
        }
    });
}

$(document).on('ready', function() {
    $('#invoices-table').bootgrid({
        converters: {
            invoice: {
                from: function(value) { return parseInt(value.replace(/^0+/,"")); },
                to: function(value) { return value.toString().pad('0',8) }
            }
        },
        formatters: {
           "invoice": function (column, row) {
               return '<a href="' + appSettings.homeURI + '/Invoices/Show/' + row.id + '">' + row.id.toString().pad("0",8) + '</a>';
           },
           "quote": function (column, row) {
               return '<a href="' + appSettings.homeURI + '/Quotes/Show/' + row.quote + '">' + row.quote.toString().pad("0",8) + '</a>';
           },
           "client": function (column, row) {
               return "<a onclick=\"$('#invoices-table').bootgrid('search','" + row.clientName + "')\">" + row.clientName + "</a>";
               //return '<a href="' + appSettings.homeURI + '/Clients/Show/' + row.clientId + '">' + row.clientName + '</a>';
           },
           "invoiceActions": function (column, row) {
               return '<button class="btn btn-xs btn-danger btn-invoice-delete" data-delete-id="' + row.id + '" data-delete-name="' + htmlEntities(row.id.toString().pad("0", 8)) + '"><i class="fa fa-fw fa-trash"></i></button>' +
                      '&nbsp;<a class="btn btn-xs btn-default" href="' + appSettings.homeURI + '/Invoices/Update/' + row.id + '"><i class="fa fa-fw fa-edit"></i></a>';
           }
       }
   }).on('loaded.rs.jquery.bootgrid', function() {
        $('.btn-invoice-delete').each(function() {
            $(this).off('click');
            $(this).on('click', function() {
                var deleteId = $(this).data('delete-id');
                $('#confirm-modal-title').html('Delete invoice <strong>' + $(this).data('delete-name') + '</strong>');
                $('#confirm-modal-body').html('Are you sure you want to delete the invoice <strong>' + $(this).data('delete-name') + '</strong>?<br><small>This action in can not be undone!</small>');
                $('#confirm-button').html('<i class="fa fa-fw fa-trash"></i> Delete').addClass('btn-danger').data('delete-id', deleteId).off('click').on('click', function() { deleteInvoice($(this).data('delete-id')); });
                $('#confirm-modal').addClass('modal-danger').modal('show');
            });
        })
    });
});