
var Validateconfig = function() {
 
    // function to initiate Validation Sample 1
    var msg1 = $("#error_msg1").html();
    var msg4 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg5 = $("#error_msg5").html(); 
    var runValidatorweeklySelection = function() {
	var searchform = $('#board_form');
         var errorHandler1 = $('.errorHandler', searchform);
	
	$('#rank_form').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		// error.insertAfter($(element).closest('.input-group'));
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		board_depth: {
		    minlength: 1,
		    required: true
		},
		board_width: {
		    minlength: 1,
		    required: true
		},
		board_name: {
		    minlength: 1,
		    required: true
		},
                board_commission: {
		    minlength: 1,
		    required: true
		}

	    },
	    messages: {
		board_name: msg5,
		

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

	}
    };
}();

$(function()
{
   Validateconfig.init();
   var msg = $("#error_msg1").html();
     $("#board_width").keypress(function(e)
    {

        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
            $("#errmsg1").html(msg).show().fadeOut(1200, 0);
            return false;
        }
    });

    $("#board_depth").keypress(function(e)
    {



        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
            $("#errmsg2").html(msg).show().fadeOut(1200, 0);
            return false;
        }
        
    });
    $("#board_commission").keypress(function(e)
    {



        //if the letter is not digit then display error and don't type anything
       if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57))
        {
            //display error message
            $("#errmsg3").html(msg).show().fadeOut(1200, 0);
            return false;
        }
    });


    return true;


});