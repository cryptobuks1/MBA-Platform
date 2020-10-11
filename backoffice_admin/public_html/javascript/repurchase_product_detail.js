$(function () {
    getTotalAmount();
    ValidateUser.init();
});

function getTotalAmount() {
    var count = $('#product_qty').val();
    if (count % 1 == 0 && count > 0 && count <= 100){
        var pv = $('#pv').val();
        var price = $('#product_price').val();
        var default_currency_val = $('#DEFAULT_CURRENCY_VALUE').val();
        var default_precision = $('#DEFAULT_PRECISION').val();
        var total_amount = parseInt(count) * parseFloat(price);
        var total_amount_converted = (total_amount / parseFloat(default_currency_val)).toFixed(default_precision);
        var total_pv = parseInt(count) * parseFloat(pv);
        $('#tot_price').val(total_amount);
        $('#tot_price_converted').val(total_amount_converted);
        $('#tot_pv').val(total_pv);
        $('#purchase_request').attr('disabled', false);
    } else {
        $('#tot_price').val('');
        $('#tot_price_converted').val('');
        $('#tot_pv').val('');
        $('#purchase_request').attr('disabled', true);
    }
}

function update_cart_item_by_product(rowid) {
    if ($('#request').valid()) {
        var confirm_msg = $("#confirm_msg_update").html();
        var path_root = $("#path_root").val();
        var qnty = document.getElementById('product_qty').value;
        if (confirm(confirm_msg)) {
            document.location.href = path_root + 'repurchase/updateItem/' + rowid + "/" + qnty + "/" + 'from_product';
        }
    }else{
        $('#request').submit();
    }
}