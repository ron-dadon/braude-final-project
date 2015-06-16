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
        '<tr id="product-line-row-' + productLines + '"><td>' + getProductSelect() + '</td><td class="products-prices" data-coin="' + products[0].coin + '" id="product-line-price-' + productLines + '">' + products[0].basePrice +'</td><td id="product-line-coin-' + productLines + '">' + products[0].coin +'</td></tr>'
    );
    $('#product-line-' + productLines).selectpicker()
        .on('change', function() {
            var value = $(this).val();
            var currentId = $(this).data('id');
            for (var i = 0; i < products.length; i++) {
                if (products[i].id == value) {
                    $('#product-line-price-' + currentId).html(products[i].basePrice).data('coin', products[i].coin);
                    $('#product-line-coin-' + currentId).html(products[i].coin);
                }
            }
            calcTotals();
    });
    calcTotals();
}

function calcTotals()
{
    total = 0;
    $('.products-prices').each(function() {
        var coin = $(this).data('coin');
        var value = parseInt($(this).html());
        if (coin == 'usd') {
            value *= appSettings.exchangeRate;
        }
        total += value
    });
    console.log(total);
    $('#quote-total').html(total);
}

$(document).on('ready', function() {
    $.get(appSettings.homeURI + "/Ajax/Products/All" , function(data) { getAllProducts(data); });

    $('#add-product').on('click', addProductToTable);
});