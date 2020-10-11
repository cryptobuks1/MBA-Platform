$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

function get_product_details(id) {
    $.ajax({
        type: "POST",
        url: BASE_URL + "repurchase/quick_view",
        dataType: 'json',
        data: {
            product_id: id
        },
        success: function (json) {
            alert(json['product_details']);
        }
    });
}

function add_cart(product_id, i) {
    $.ajax({
        url: BASE_URL + 'repurchase/add_to_cart',
        type: 'POST',
        data: {
            product_id: product_id
        },
        beforeSend: function () {
            $('#add_to_cart_' + i).button('loading');
        },
        complete: function () {
            $('#add_to_cart_' + i).button('reset');
        },
        success: function (data) {
            window.location.reload();
        }
    });
}