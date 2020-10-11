$(function () {
	var base_url = $('#base_url').val();

	$('#ewallet_username,#transaction_password').on('blur', function () {
		$('#ewallet_submit').attr('disabled', true);
	});

	$('#check_ewallet').on('click', function () {
                var flag =false;
		$('#ewallet_submit').attr('disabled', true);
		$('#msg_div').empty();
		$('#err_ewallet_username').empty();
		$('#err_ewallet_password').empty();
		var url = base_url + $('#controller_name').val() + '/check_ewallet_payment';
		var user_name = $('#ewallet_username').val();
                if(user_name == ''){
                    $('#err_ewallet_username').append('<i class="fa fa-times" style="color: #a94442;"></i>&nbsp;<span style="color: #a94442;">' + $('#ewallet_message4').text() +'</span>');
                    $('#err_ewallet_username').show();
                    flag =true;
                }
		var transaction_password = $('#transaction_password').val();
                if(transaction_password == ''){
                    $('#err_ewallet_password').append('<i class="fa fa-times" style="color: #a94442;"></i>&nbsp;<span style="color: #a94442;">' + $('#ewallet_message5').text() +'</span>');
                    $('#err_ewallet_password').show();
                    flag =true;
                }
                if(flag)
                    return false;
		var payment_amount = $('#payment_amount').val();
		var upgrade_username = $('#upgrade_user_name').val();
		$.ajax({
			url: url,
			type: 'post',
			data: {
				user_name: user_name,
				transaction_password: transaction_password,
				payment_amount: payment_amount,
                                upgrade_username: upgrade_username
			},
			dataType: 'text',
			success: function (data) {
				if (data == 'yes') {
					$('#ewallet_submit').attr('disabled', false);
					$('#msg_div').append('<i class="fa fa-check" style="color: green;"></i>&nbsp;' + $('#ewallet_message3').text());
				}
				else if (data == 'low_balance') {
					$('#msg_div').append('<i class="fa fa-times" style="color: red;"></i>&nbsp;' + $('#ewallet_message2').text());
				}
				else if (data == 'invalid') {
					$('#msg_div').append('<i class="fa fa-times" style="color: red;"></i>&nbsp;' + $('#ewallet_message1').text());
				}
				$('#msg_div').show();
			},
			error: function () {
				
			}
		});
	});
});
