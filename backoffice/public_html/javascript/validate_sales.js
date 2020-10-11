/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var ValidateUser = function() {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#error_msg4").html();
    var msg6 = $("#error_msg6").html();
    //var msg5 = $("#error_msg5").html();
    var msg5 = 'Please Enter a Valid Date';
    var runValidatorweeklySelection = function() {

	var searchform = $('#weekly_payout');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#weekly_payout').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type
	
                if($(element).parent('.input-group').length === 0) {
                    error.insertAfter(element);
                }
                else {
                    error.insertAfter($(element).closest('.input-group'));
                }
	    },
	    ignore: ':hidden',
	    rules: {
		"ranks[]": {
//		    required: true,
		},
		week_date1: {
		    minlength: 1,
//		    required: true,
                    date:true,
		},
		week_date2: {
		    minlength: 1,
//		    required: true,
		    todate_greaterthan_fromdate: true,
                    date: true,
		}
	    },
	    messages: {
		"ranks[]": msg6,
		week_date1: {
//                    required : msg,
                    date: msg5
                },
		week_date2: {
		    minlength: msg2,
//		    required: msg1,
		    todate_greaterthan_fromdate: msg4,
                    date:msg5
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
	jQuery.validator.addMethod('todate_greaterthan_fromdate', function(ToDate) {
        if ($("#week_date1").val() && $("#week_date2").val()) {
	    var FromDate = $("#week_date1").val();
	    return (ToDate >= FromDate);
        }
        return true;
	}, "");
    };
    var runValidatordailySelection = function() {

	var searchform = $('#user');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#user').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		
	    },
	    ignore: ':hidden',
	    rules: {
		product_id: {
		    minlength: 1,
		    required: true
		}

	    },
	    messages: {
		product_id: msg3


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


    var runValidatordailySelectionRP = function() {

	var searchform = $('#rp_user');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#rp_user').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		
	    },
	    ignore: ':hidden',
	    rules: {
		product_id: {
		    minlength: 1,
		    required: true
		}

	    },
	    messages: {
		product_id: msg3


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
	    runValidatordailySelectionRP();
	}
    };
}();