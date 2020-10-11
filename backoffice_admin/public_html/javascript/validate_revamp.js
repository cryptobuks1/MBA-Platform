$(function()
{
    ValidateRevamp.init(); 
});

var ValidateRevamp = function() {

    var msg = $("#error_msg1").html();
    var msg1 = $("#error_msg2").html();
    var msg2 = $("#error_msg3").html();
    var msg3 = $("#error_msg4").html();
    var runValidateRevamp = function() {
        $.validator.addMethod("url_check", function (value, element) {
            return  this.optional(element) || /^http(s)?:\/\/(www\.)[a-zA-Z0-9(\.\?)?]/.test(value);
        }, msg3);
	var searchform = $('#update_form');
	var errorHandler1 = $('.errorHandler', searchform);

	$('#update_form').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		mlm_details: {
		    required: true
		},
		reference: {
		    required: true,
                    url_check: true
		}
	    },
	    messages: {
		mlm_details: {
                required: msg
                },
		reference: {
                    required: msg1
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
	    runValidateRevamp();

	}
    };
}();