/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

/*
 * Products Index
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
           "manufactor": function (column, row) {
               return "<a style=\"cursor:pointer\" title=\"Filter by " + row.productManufacturer + "\" onclick=\"$('#products-table').bootgrid('search','" + row.productManufacturer + "')\">" + row.productManufacturer + "</a>";
               //return '<a href="' + appSettings.homeURI + '/Clients/Show/' + row.clientId + '">' + row.clientName + '</a>';
           },
           "types": function (column, row) {
               return "<a style=\"cursor:pointer\" title=\"Filter by " + row.productType + "\" onclick=\"$('#products-table').bootgrid('search','" + row.productType + "')\">" + row.productType + "</a>";
               //return '<a href="' + appSettings.homeURI + '/Clients/Show/' + row.clientId + '">' + row.clientName + '</a>';
           },
           "licenses": function (column, row) {
			   if (row.productType == 'Training') return;
               return "<a style=\"cursor:pointer\" title=\"Filter by " + row.productLicense + "\" onclick=\"$('#products-table').bootgrid('search','" + row.productLicense + "')\">" + row.productLicense + "</a>";
               //return '<a href="' + appSettings.homeURI + '/Clients/Show/' + row.clientId + '">' + row.clientName + '</a>';
           },
           "productLink": function (column, row) {
               return '<a href="' + appSettings.homeURI + '/Products/Show/' + row.id + '" title="Show ' + row.productName + '">' + row.productName + '</a>';
           },
           "productActions": function (column, row) {
               return '<button class="btn btn-xs btn-danger btn-product-delete" data-delete-id="' + row.id + '" data-delete-name="' + htmlEntities(row.productName) + '" title="Update ' + htmlEntities(row.productName) + '"><i class="fa fa-fw fa-trash"></i></button>' +
                      ' <a class="btn btn-xs btn-default" href="' + appSettings.homeURI + '/Products/Update/' + row.id + '" title="Delete ' + htmlEntities(row.productName) + '"><i class="fa fa-fw fa-edit"></i></a>';
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