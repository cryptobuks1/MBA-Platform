$(function() {
    $('#upgrade_pack_div').hide();
    $('#amount_to_pay').closest('.form-group').hide();
    $('#payment_section').hide();

    $('#search_member').attr('action', $('#base_url').val() + 'upgrade/search_member');
    $('.nav-tabs a[href="#' + $('#active_tab').val() + '"]').tab('show');

    var base_url = $('#base_url').val();
    var default_symbol_left = $('#DEFAULT_SYMBOL_LEFT').val();
    var default_symbol_right = $('#DEFAULT_SYMBOL_RIGHT').val();
    var default_currency_value = parseFloat($('#DEFAULT_CURRENCY_VALUE').val());

    $('#product_id').on('change', function() {
        var product_id = this.value;
        if (!product_id) {
            $('#upgrade_pack_div').hide();
            $('#amount_to_pay').closest('.form-group').hide();
            $('#payment_section').hide();
        } else {
            $.ajax({
                url: base_url + '/upgrade/package_info',
                type: 'get',
                data: {
                    product_id: product_id
                },
                dataType: 'json',
                success: function(data) {
                    if (data['product_id']) {
                        $('#package_id').text(data['package_id']);
                        $('#package_name').text(data['product_name']);
                        var price = parseFloat(data['price'] * default_currency_value);
                        $('#package_price').text(default_symbol_left + price.toFixed(2) + default_symbol_right);
                        $('#package_pv').text(data['pair_value']);
                        var current_package_price = parseFloat($('#current_package_price').val());
                        var amount_to_pay = ((data['price'] - current_package_price) * default_currency_value);
                        $('#amount_to_pay').text(default_symbol_left + amount_to_pay.toFixed(2) + default_symbol_right);
                        $('#upgrade_pack_div').show();
                        $('#amount_to_pay').closest('.form-group').show();
                        $('#payment_amount').val(data['price'] - current_package_price);
                        $('#payment_section').show();
                    } else {
                        $('#upgrade_pack_div').hide();
                        $('#amount_to_pay').closest('.form-group').hide();
                        $('#payment_section').hide();
                    }
                },
                error: function() {
                    $('#upgrade_pack_div').hide();
                    $('#amount_to_pay').closest('.form-group').hide();
                    $('#payment_section').hide();
                }
            });
        }
    });
    $("#upgrde").submit(function() {
        $("#transaction_password").val(encodeURIComponent(window.btoa($("#transaction_password").val())));
    });
});