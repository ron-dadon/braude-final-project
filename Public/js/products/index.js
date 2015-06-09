/*
 * Clients Index
 */
function deleteProduct(id)
{
    $.post(appSettings.homeURI + "/Products/Delete", { delete_id: id } , function(result) {
        result = JSON.parse(result);
        var productName = result.details.product;
        $('#confirm-modal').modal('hide');
        if (result.result === true)
        {
            showMessageAlert('<i class="fa fa-fw fa-check-circle"></i>', 'Product deleted successfully!', 'The product <strong>' + productName + '</strong> was deleted.', 'success', true);
            $('#products-table').bootgrid("remove", [id]);
        }
        else
        {
            showMessageAlert('<i class="fa fa-fw fa-times-circle"></i>', 'Product deletion failed!', 'The product <strong>' + productName + '</strong> was not deleted.', 'danger', true);
        }
    });
}

$(document).on('ready', function() {
    $('#products-table').bootgrid({
       formatters: {
           "productLink": function (column, row) {
               return '<a href="' + appSettings.homeURI + '/Products/Show/' + row.id + '">' + row.productName + '</a>';
           },
           "productActions": function (column, row) {
               return '<button class="btn btn-xs btn-danger btn-product-delete" data-delete-id="' + row.id + '" data-delete-name="' + htmlEntities(row.productName) + '"><i class="fa fa-fw fa-trash"></i></button>' +
                      ' <a class="btn btn-xs btn-default" href="' + appSettings.homeURI + '/Products/Update/' + row.id + '"><i class="fa fa-fw fa-edit"></i></a>';
           }
       }
   }).on('loaded.rs.jquery.bootgrid', function() {
        $('.btn-product-delete').each(function() {
            $(this).off('click');
            $(this).on('click', function() {
                var deleteId = $(this).data('delete-id');
                $('#confirm-modal-title').html('Delete product <strong>' + $(this).data('delete-name') + '</strong>');
                $('#confirm-modal-body').html('Are you sure you want to delete the product <strong>' + $(this).data('delete-name') + '</strong>?<br><small>This action in can not be undone!</small>');
                $('#confirm-button').html('<i class="fa fa-fw fa-trash"></i> Delete').addClass('btn-danger').data('delete-id', deleteId).off('click').on('click', function() { deleteProduct($(this).data('delete-id')); });
                $('#confirm-modal').addClass('modal-danger').modal('show');
            });
        })
    });
});