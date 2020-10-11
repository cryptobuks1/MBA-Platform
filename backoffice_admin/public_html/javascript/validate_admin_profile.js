var ValidateUser = function() {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#error_msg4").html();
    var msg5 = $("#error_msg5").html();
    var msg6 = $("#error_msg6").html();
    var msg9 = $("#error_msg9").html();    
    var error_message2 = $('#error_msg7').html();
    var runValidatorweeklySelection = function() {    
            $.validator.addMethod("username_check", function(value, element) {
                var path_root = $('#base_url').val();
                var flag2 = false;
                if (value != "/" && value != ".") {
                    $.ajax({
                        'url': path_root + getUserType() + "/profile/validate_username",
                        'type': "POST",
                        'data': {username: value},
                        'dataType': 'text',
                        'async': false,
                        'success': function (data) {
                            if (data == 'no') {
                                flag2 = false;
                            }
                            else if (data == 'yes') {
                                flag2 = true;
                            }
                        },
                        'error': function (error) {
                        },
                    });
                    return flag2;
                }
                else
                {
                    return true;
                }
        },error_message2); 
        
	var searchform = $('#searchform');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#searchform').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		error.insertAfter($(element).closest('.input-group'));
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		user_name: {
		    minlength: 1,
		    required: true,
                    username_check:true
		}
	    },
	    messages: {               
                 user_name: {
                    required:msg,
                    username_check:error_message2
                }
	    },
            onkeyup: false,
            onfocusout: function(element) { 
                $(element).valid(); 
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
    var runValidatorcountSelection = function() {
	var searchform = $('#searchform1');

	var errorHandler1 = $('.errorHandler', searchform);
	$('#searchform1').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		count: {
		    required: true,
		    digits: true,
		    min: 1
		}
	    },
	    messages: {
		count: {
                    required: msg3,
		    digits: msg9,
                    min:msg6}


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
	var searchform = $('#from_to_form');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#from_to_form').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		count_from: {
		    min: 1,
		    number: true,
		    digits: true,
		    required: true
		},
		count_to: {
		    min: 1,
		    number: true,
		    digits: true,
		    required: true
		}
	    },
	    messages: {
		count_from: {
                    required: msg4,
		    number: msg9,
                    min:msg6},
		count_to: {
                    required: msg5,
		    number: msg9,
                    min:msg6
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
	    runValidatorcountSelection();
	    runValidatordailySelection();
	}
    };
}();



    $("#count,#count_from,#count_to").keypress(function(e) {
        if (e.which == 0 || e.which == 8) {
            return;
        }
        var regex = new RegExp("^[0-9]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        else {
            var msg = $("#error_msg9").html();
            showErrorSpanOnKeyup(this, msg);
            return false;
        }
    });

function showErrorSpanOnKeyup(element, message) {
    var span = "<span class='keyup_error' style='color: #b94a48;'>" + message + "</span>";
    if ($(element).closest('.input-group').length) {
        $(element).closest('.input-group').next('span.keyup_error').remove();
        $(element).closest('.input-group').after(span);
        $(element).closest('.input-group').next('span:first').fadeOut(2000, 0);
    }
    else {
        $(element).next('span.keyup_error').remove();
        $(element).after(span);
        $(element).next('span:first').fadeOut(2000, 0);
    }
}