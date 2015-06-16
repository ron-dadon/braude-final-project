/*
 * Quotes New
 */

var products = [];

var total;
var productLines = 0;
var totalUSD;
var totalNIS;


function getAllProducts(data)
{
    products = JSON.parse(data);
}

function changeProduct(id) {

}

function getProductSelect() {
    var output = '<select class="selectpicker" data-live-search="true" data-width="100%" name="quote_product[]" id="product-line-' + productLines + '" data-id="' + productLines + '">';
    for (var i = 0; i < products.length; i++) {
        output += '<option value="' + products[i].id + '">' + products[i].name + '</option>';
    }
    output += '</select>';
    return output;
}

function addProductToTable() {
    productLines++;
    $('#quote-products-table').append(
        '<tr id="product-line-row-' + productLines + '"><td>' + getProductSelect() + '</td><td class="products-prices" data-coin="' + products[0].coin + '" data-quantity="1" id="product-line-price-' + productLines + '">' + products[0].basePrice +'</td><td id="product-line-coin-' + productLines + '">' + products[0].coin +'</td>' +
        '<td><input type="number" name="product_quantity[]" id="product-quantity-' + productLines + '" value="1" data-id="' + productLines + '"></td><td><button type="button" id="delete-row-' + productLines + '" data-delete-id="' + productLines + '" class="btn btn-xs btn-danger"><i class="fa fa-fw fa-times"></i></button></td></tr>'
    );
    $('#product-line-' + productLines).selectpicker()
        .on('change', function() {
            var value = $(this).val();
            var currentId = $(this).data('id');
            for (var i = 0; i < products.length; i++) {
                if (products[i].id == value) {
                    $('#product-line-price-' + currentId).html(products[i].basePrice).data('coin', products[i].coin).data('quantity', 1);
                    $('#product-line-coin-' + currentId).html(products[i].coin);
                    $('#product-quantity-' + currentId).val(1);
                }
            }
            calcTotals();
    });
    $('#product-quantity-' + productLines).on('change', function() {
        var value = $(this).val();
        var currentId = $(this).data('id');
        $('#product-line-price-' + currentId).data('quantity',value);
        calcTotals();
    });
    $('#delete-row-' + productLines).on('click', function(){
        var id = $(this).data('delete-id');
        $('#product-line-row-' + id).remove();
        calcTotals();
    });
    calcTotals();
}

function calcTotals()
{
    total = 0;
    var tax = 0;
    var totalTax = 0;
    var discount = $('#quote-discount').val();
    $('.products-prices').each(function() {
        var coin = $(this).data('coin');
        var q = $(this).data('quantity');
        var value = parseInt($(this).html());
        if (coin == 'usd') {
            value *= appSettings.exchangeRate;
        }
        total += q * value
    });
    total = total * (1 - (discount/100));
    tax = total * (appSettings.tax / 100);
    totalTax = total + tax;
    $('#quote-total').html(parseInt(total));
    $('#quote-tax').html(parseInt(tax));
    $('#quote-total-tax').html(parseInt(totalTax));

}

$(document).on('ready', function() {
    $.get(appSettings.homeURI + "/Ajax/Products/All" , function(data) { getAllProducts(data); });
    $('#add-product').on('click', addProductToTable);
    $('#quote-discount').on('change', calcTotals).on('keyup', calcTotals);
});