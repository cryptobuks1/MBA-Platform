$(function () {
	var base_url = $('#base_url').val();

	$('.epin_input').on('blur', function () {
		$('#epin_submit').attr('disabled', true);
	});

	var invalid_span = '<span id="msg_epin_invalid"><i style="color: red;" class="fa fa-times"></i>&nbsp;Invalid E-Pin</span>';
	var valid_span = '<span id="msg_epin_valid"><i style="color: green;" class="fa fa-check"></i>&nbsp;Valid E-Pin</span>';
        
        var duplicate_span = '<span id="msg_epin_invalid"><i style="color: red;" class="fa fa-times"></i>&nbsp;Duplicate E-Pin</span>';
	$('#check_epin').on('click', function () {
            var status;
		$('#epin_submit').attr('disabled', true);
		$('table#epin_table > tbody > tr > td:nth-child(2) > input').next('span').remove();
		var epin_array = [];
		$('table#epin_table > tbody > tr > td:nth-child(2) > input').each(function (i) {
			var epin = this.value;
			epin = epin.trim();
			//epin = epin.toUpperCase();
			var epin_exists = ($.inArray(epin, epin_array) !== -1);
			if ((!epin || epin_exists) && epin != '') {
				//$(this).closest('tr').remove();
                                status = false;
                               $('table#epin_table > tbody > tr:eq(' + i + ')').find('td:nth-child(2) > span').remove();
			       $('table#epin_table > tbody > tr:eq(' + i + ')').find('td:nth-child(2) > input').after(duplicate_span)
			}
			else {
				epin_array.push(epin);
			}
		});
		if (!$.isEmptyObject(epin_array)) {
			var payment_amount = $('#payment_amount').val();
			var upgrade_user_name = $('#upgrade_user_name').val();
			$.ajax({
				url: $('#base_url').val() + 'upgrade/check_epin_payment',
				type: 'POST',
				data: {
					epin_array: epin_array,
					payment_amount: payment_amount,
                                        upgrade_user_name: upgrade_user_name
				},
				dataType: 'json',
				success: function (data) {
					var amount_reached = 0;
					if(status !=false)
                                        {
                                        status = true;
                                        }
					$.each(data, function (i, v) {
						if (i == 'valid' || i == 'amount_reached') {
							return false;
						}
						if (v.pin == 'nopin') {
							status = false;
							$('table#epin_table > tbody > tr:eq(' + i + ')').find('td:nth-child(2) > span').remove();
							$('table#epin_table > tbody > tr:eq(' + i + ')').find('td:nth-child(2) > input').after(invalid_span);
						}
						else {
							amount_reached += Number(v.epin_used_amount);
							$('table#epin_table > tbody > tr:eq(' + i + ')').find('td:nth-child(2) > span').remove();
							$('table#epin_table > tbody > tr:eq(' + i + ')').find('td:nth-child(2) > input').after(valid_span);
							$('table#epin_table > tbody > tr:eq(' + i + ')').find('td:nth-child(3) > input').val(v.amount);
							$('table#epin_table > tbody > tr:eq(' + i + ')').find('td:nth-child(4) > input').val(v.balance_amount);
							$('table#epin_table > tbody > tr:eq(' + i + ')').find('td:nth-child(5) > input').val(v.reg_balance_amount);
							if (v.reg_balance_amount == 0) {
								$('table#epin_table > tbody > tr:gt(' + i + ')').remove();
								return false;
							}
						}
					});
					$('#epin_total_amount').val(amount_reached);
					if (status && amount_reached == payment_amount) {
						$('#epin_submit').attr('disabled', false);
					}
					else {
						$('#epin_submit').attr('disabled', true);
					}
					if (amount_reached < payment_amount && status) {
						var epin_row = $('#epin_row > table > tbody').contents().clone();
						$('table#epin_table > tbody').append(epin_row);
					}
				}
			});
		}
		var epin_row = $('#epin_row > table > tbody').contents().clone();
		var rows = $('table#epin_table > tbody > tr').length;
		if (rows == 0) {
			$('table#epin_table > tbody').append(epin_row);
		}
		var sl_no = 1;
		$('table#epin_table > tbody > tr').each(function () {
			$(this).find('td:first').text(sl_no);
			sl_no++;
		});
	});
});
