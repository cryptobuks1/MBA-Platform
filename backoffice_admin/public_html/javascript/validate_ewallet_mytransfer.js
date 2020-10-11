var ValidateUser = function() {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg1").html();
    var msg1 = $("#error_msg2").html();
    var msg2 = $("#error_msg3").html();
    var msg4 = $("#error_msg4").html();
   // var msg5 = $("#error_msg5").html();
    var msg5 = 'Please Enter a Valid Date';
    var runValidatorweeklySelection = function() {
	var searchform = $('#weekly_join');
	var errorHandler1 = $('.errorHandler', searchform);

	$('#weekly_join').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type
		error.insertAfter($(element).closest('.input-group'));
		if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		user_name: {
		    minlength: 1,
//		    required: true
		},
		week_date1: {
		    minlength: 1,
                    required: true,
                    date:true
		},
		week_date2: {
		    minlength: 1,
 		    required: true,
                    date:true,
                    todate_greaterthan_fromdate: true
		}
	    },
	    messages: {
		user_name: msg,
		week_date1: 
                        {required:msg1,
                         date:msg5,
                        },
		week_date2: {
		    minlength: msg2,
		    required: msg1,
                    date:msg5,
		    todate_greaterthan_fromdate: msg4
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
	    var FromDate = $("#week_date1").val();
	    return (ToDate > FromDate);
	});
    };
    var runValidatordailySelection = function() {
	var searchform = $('#daily_transfer');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#daily_transfer').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type
		if ($(element).hasClass("date-picker")) {
			error.insertAfter($(element).closest('.Zebra_DatePicker_Icon_Wrapper'));
		}
		else
		{
                    error.insertAfter(element);
                }
		;
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		user_name1: {
		    minlength: 1,
//		    required: true
		},
		week_date3: {
		    minlength: 1,
		    required: true,
                    date:true
		}
	    },
	    messages: {
		user_name1: msg,
		week_date3 :{
                   required : msg1,
                   date : msg5
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