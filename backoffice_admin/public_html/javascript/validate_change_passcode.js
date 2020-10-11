var ValidateUser = function() {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg1").html();
    var msg1 = $("#error_msg2").html();
    var msg2 = $("#error_msg3").html();
    var msg3 = $("#error_msg4").html();
    var msg4 = $("#error_msg5").html();
    var msg5 = $("#error_msg6").html();
    var runValidatorweeklySelection = function() {
	var searchform = $('#change_pass');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#change_pass').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorId: 'admin_tp',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		old_passcode: {
		    minlength: 8,
		    required: true
		},
		new_passcode: {
		    minlength: 8,
		    required: true
		},
		re_new_passcode: {
		    minlength: 8,
		    required: true,
                    equalTo: "#new_passcode"
		}
	    },
	    messages: {
		old_passcode: {
		    minlength: msg2,
                    required: msg,
                },
		new_passcode: {
		    minlength: msg2,
                    required: msg1
                },
		re_new_passcode: {
		    minlength: msg2,
                    required: msg3,
                    equalTo: msg4
                } 



	    },
	    invalidHandler: function(event, validator) { //display error alert on form submit
		errorHandler1.show();
	    },
	    highlight: function(element) {
		$(element).closest('.help-block').removeClass('valid');
		// display OK icon
		$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
		// add the Bootstrap error class to the control group
	    },
	    unhighlight: function(element) { // revert the change done by hightlight
		$(element).closest('.form-group').removeClass('has-error');
		// set error class to the control group
	    },
	    success: function(label, element) {
		label.addClass('help-block valid');
		// mark the current input as valid and display OK icon
		//$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
		$(element).closest('.form-group').removeClass('has-error').addClass('ok');
	    }
	});
    };
    var runValidatordailySelection = function() {
	var searchform = $('#change_pass_user');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#change_pass_user').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorId: 'user_tp',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		user_name: {
		    minlength: 1,
		    required: true
		},
		new_passcode_user: {
		    minlength: 8,
		    required: true
		},
		re_new_passcode_user: {
		    minlength: 8,
		    required: true,
                    equalTo: "#new_passcode_user"
		}
	    },
	    messages: {
		user_name: msg5,
		new_passcode_user: {
		    minlength: msg2,
                    required: msg1
                },
		re_new_passcode_user: {
		    minlength: msg2,
                    required: msg3,
                    equalTo: msg4
                } 



	    },
	    invalidHandler: function(event, validator) { //display error alert on form submit
		errorHandler1.show();
	    },
	    highlight: function(element) {
		$(element).closest('.help-block').removeClass('valid');
		// display OK icon
		$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
		// add the Bootstrap error class to the control group
	    },
	    unhighlight: function(element) { // revert the change done by hightlight
		$(element).closest('.form-group').removeClass('has-error');
		// set error class to the control group
	    },
	    success: function(label, element) {
		label.addClass('help-block valid');
		// mark the current input as valid and display OK icon
		//$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
		$(element).closest('.form-group').removeClass('has-error').addClass('ok');
	    }
	});
    };
    return {
	//main function to initiate template pages
	init: function() {
	    runValidatorweeklySelection();
	    runValidatordailySelection();
	}
    };
}();
$(function(){
    var base_url = $("#base_url").val();
    $('#user_name_1').on('blur', function () {
        $('#e_mail_1').val('');
        $('#e_mail').val('');
        var user_name = $('#user_name_1').val();
        $.ajax({
            url: base_url + 'admin/tran_pass/get_email',
            type: 'POST',
            data: {
                user_name: user_name,
            },
            dataType: 'text',
            success: function (data) {
                if (data != 'no') {
                    $('#err_usr_name').text('');
                    $('#e_mail_1').val(data);
                    $('#e_mail').val(data);
                }
            }});
	});
	
    var error_message = $('#search_member_error').val();
    var error_message2 = $('#search_member_error2').val();
    var error_message3 = $('#error_msg8').html();

	var searchform = $('#forgot_trans_password');
	var errorHandler = $('.errorHandler', searchform);
	$(searchform).validate({
		errorElement: 'span',
		errorClass: 'help-block',
		errorId: 'forgot_tp',
		errorPlacement: function(error, element) {
			error.insertAfter(element);
		},
		ignore: ':hidden',
		rules: {
			user_name: {
				required: true,
				username_check: true
			},
			captcha: {
				required: true,
			}
		},
		messages: {
			user_name: {
				required: error_message,
				username_check: error_message2,
			},
			captcha: {
				required: error_message3,
			}
		},
		// onkeyup: false,
		// onfocusout: function(element) {
		// 	$(element).valid();
		// },
		invalidHandler: function(event, validator) {
			errorHandler.show();
		},
		highlight: function(element) {
			$(element).closest('.help-block').removeClass('valid');
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
		},
		unhighlight: function(element) {
			$(element).closest('.form-group').removeClass('has-error');
		},
		success: function(label, element) {
			label.addClass('help-block valid');
			$(element).closest('.form-group').removeClass('has-error').addClass('ok');
		}
	});

});