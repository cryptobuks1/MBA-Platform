
var ValidateUser = function() {

    var runValidatorweeklySelection = function() {

	//alert('dddd');
	var msg1 = $("#validate_msg15").html();
	var msg2 = $("#validate_msg16").html();
	var msg3 = $("#validate_msg17").html();
	var msg4 = $("#validate_msg18").html();
	var searchform = $('#reset_password_form');
	var errorHandler1 = $('.errorHandler', searchform);

	$('#reset_password_form').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) {

		// render error placement for each input type
		error.insertAfter($(element).closest('.input-group'));
		error.insertAfter(element);
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		pass: {
		    minlength: 6,
		    required: true
		},
		confirm_pass: {
		    minlength: 6,
		    required: true,
		    equalTo: "#pass"
		}

	    },
	    messages: {
		pass: {required: msg1,
		    minlength: msg2},
		confirm_pass: {required: msg3,
		    minlength: msg2,
		    equalTo: msg4}
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

    var runValidateTranpass = function() {

	//alert('dddd');
	var msg1 = $("#validate_msg1").html();

	var searchform = $('#searchform');
	var errorHandler1 = $('.errorHandler', searchform);

	$('#searchform').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) {

		// render error placement for each input type
		error.insertAfter($(element).closest('.input-group'));
		error.insertAfter(element);
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		user_name: {
		    required: true
		}

	    },
	    messages: {
		user_name: msg1
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
	    runValidateTranpass();

	}
    };
}();

$(function () {
	ValidateUser.init();
});