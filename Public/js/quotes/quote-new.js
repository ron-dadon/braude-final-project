/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

/*
 * Quotes New
 */

var products = [];

var total;
var productLines = 0;

function getAllProducts(data)
{
    products = JSON.parse(data);
}

function getProductSelect() {
    var output = '<select class="selectpicker" data-live-search="true" data-width="100%" name="quote_products[]" id="product-line-' + productLines + '" data-id="' + productLines + '">';
    for (var i = 0; i < products.length; i++) {
        output += '<option value="' + products[i].id + '">' + products[i].name + (products[i].type == 'software' ? ' (' + products[i].license.name + ')' : '') + '</option>';
    }
    output += '</select>';
    return output;
}

function addProductToTable() {
    productLines++;
    $('#quote-products-table').append(
        '<tr id="product-line-row-' + productLines + '"><td>' + getProductSelect() + '</td><td class="products-prices" data-coin="' + products[0].coin + '" data-quantity="1" id="product-line-price-' + productLines + '">' + formatNumber(products[0].basePrice) +'</td><td id="product-line-coin-' + productLines + '">' + products[0].coin +'</td>' +
        '<td><input type="number" class="form-control" name="product_quantity[]" id="product-quantity-' + productLines + '" value="1" min="1" data-id="' + productLines + '"></td><td><button type="button" id="delete-row-' + productLines + '" data-delete-id="' + productLines + '" class="btn btn-xs btn-danger"><i class="fa fa-fw fa-times"></i></button></td></tr>'
    );
    $('#product-line-' + productLines).selectpicker()
        .on('change', function() {
            var value = $(this).val();
            var currentId = $(this).data('id');
            for (var i = 0; i < products.length; i++) {
                if (products[i].id == value) {
                    $('#product-line-price-' + currentId).html(formatNumber(products[i].basePrice)).data('coin', products[i].coin).data('quantity', 1);
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
        var value = parseInt($(this).html().replace(',',''));
        if (coin == 'usd') {
            value *= appSettings.exchangeRate;
        }
        total += q * value
    });
    total = total * (1 - (discount/100));
    tax = total * (appSettings.tax / 100);
    totalTax = total + tax;
    $('#quote-total').html(formatNumber(parseInt(total).toString()));
    $('#quote-tax').html(formatNumber(parseInt(tax).toString()));
    $('#quote-total-tax').html(formatNumber(parseInt(totalTax).toString()));
    $('#add-quote-btn').prop('disabled', total === 0);
    $('#add-quote-btn-xs').prop('disabled', total === 0);
}

$(document).on('ready', function() {
    $.get(appSettings.homeURI + "/Ajax/Products/All" , function(data) { getAllProducts(data); });
    $('#add-product').on('click', addProductToTable);
    $('#quote-discount').on('change', function() {
        var currentVal = $(this).val();
        if (currentVal < 0) {
            $(this).val(0);
        } else if (currentVal > 100) {
            $(this).val(100);
        } else if (currentVal == '') {
            $(this).val(0);
        }
        calcTotals();
    }).on('keyup', function() {
         var currentVal = $(this).val();
        if (currentVal < 0) {
            $(this).val(0);
        } else if (currentVal > 100) {
            $(this).val(100);
        } else if (currentVal == '') {
            $(this).val(0);
        }
         calcTotals();
     }).keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: Ctrl+C
            (e.keyCode == 67 && e.ctrlKey === true) ||
            // Allow: Ctrl+X
            (e.keyCode == 88 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    $('#new-quote-form').on('submit', function() {
        return $(this).find('.products-prices').length > 0;
    });
});