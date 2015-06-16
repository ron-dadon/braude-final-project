/*
 * Quotes New
 */

var products = [];
var rows = [];

function getAllProducts(data)
{
    products = JSON.parse(data);
}

function changeProduct(id) {

}

function getProductSelect() {
    var output = '<select class="selectpicker" data-live-search="true" data-width="100%" name="quote_product[]">';
    for (var i = 0; i < products.length; i++) {
        output += '<option value="' + products[i].id + '">' + products[i].name + '</option>';
    }
    output += '</select>';
    return output;
}

function addProductToTable() {
    rows.push(products[0]);
    $('#quote-products-table').append(
        '<tr><td>' + getProductSelect() + '</td><td>' + products[0].basePrice +'</td><td>' + products[0].coin +'</td></tr>'
    );
    $('.selectpicker').selectpicker();
}

$(document).on('ready', function() {
    $.get(appSettings.homeURI + "/Ajax/Products/All" , function(data) { getAllProducts(data); });

    $('#add-product').on('click', addProductToTable);
});