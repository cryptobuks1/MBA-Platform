$(function(){
   
    $('#search_member').attr('action', $('#base_url').val() + 'admin/member/search_member_upgrade');
    $('.nav-tabs a[href="#' + $('#active_tab').val() + '"]').tab('show');
    var base_url = $('#base_url').val();
    var default_symbol_left = $('#DEFAULT_SYMBOL_LEFT').val();
    var default_symbol_right = $('#DEFAULT_SYMBOL_RIGHT').val();
    var default_currency_value = parseFloat($('#DEFAULT_CURRENCY_VALUE').val());

    $('#product_id').on('change', function () {
		var product_id = this.value;
		if (!product_id) {
			$('#upgrade_pack_div').hide();
			$('#upgrade_button').hide();
		}
		else {
			$.ajax({
				url: base_url + 'admin/member/package_info',
				type: 'get',
				data: {
					product_id: product_id
				},
				dataType: 'json',
				success: function (data) {
					if (data['product_id']) {
						$('#package_id').text(data['package_id']);
						$('#package_name').text(data['product_name']);
						var price = parseFloat(data['price'] * default_currency_value);
						$('#package_price').text(default_symbol_left + price.toFixed(2) + default_symbol_right);
						$('#upgrade_pack_div').show();
						$('#upgrade_button').show();
					}
					else {
						$('#upgrade_pack_div').hide();
						$('#upgrade_button').hide();
					}
				},
				error: function () {
					$('#upgrade_pack_div').hide();
					$('#upgrade_button').hide();
				}
			});
		}
	});
});