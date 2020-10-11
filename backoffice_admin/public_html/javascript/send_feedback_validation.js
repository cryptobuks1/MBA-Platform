

var ValidateFeed = function() {
   
    // function to initiate Validation Sample 1
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    
    var send_feedback_validation = function() {
        var searchform = $('#feedback_form');
        
        var errorHandler1 = $('.errorHandler', searchform);
        $('#feedback_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                 error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
                if ($(element).hasClass("date-picker")) {
                    error.insertAfter($(element).closest('.input-group'));
                } else if ($(element).hasClass("ckeditor")) {
                    error.insertAfter($('#cke_feedback_detail'));
                } else
                {
                    error.insertAfter(element);
                }
                ;
            },
            ignore: [],

            
            rules: {
                feedback_subject: {
                    required: true
                },
                
                feedback_detail: {
                    minlength: 1,
                    required: true
                },
              
            },
            messages: {
                feedback_subject: msg1,
                feedback_detail: {
		    required:msg2
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
            send_feedback_validation();

        }
    };
}();
$(function()
{
   ValidateFeed.init();
});