


var ValidateUser = function() {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
//    var msg2 = $("#error_msg2").html();
//    var msg3 = $("#error_msg3").html();
//    var msg4 = $("#error_msg4").html();
//    var msg5 = $("#error_msg5").html();
    var runValidatorweeklySelection = function() {
        var searchform = $('#upload_news');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#upload_news').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                //error.insertAfter(element);
				 error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                news_title: {
                    minlength: 1,
                    required: true
                },
              news_desc: {
                    minlength: 1,
                    required: true
                }
          
               
            },
            messages: {
                 news_title: msg,
                news_desc: msg1
               
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
 /*   var runValidatordailySelection = function() {
        var searchform = $('#change_pass_common');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#change_pass_common').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                user_name_common: {
                    minlength: 1,
                    required: true
                },
                new_pwd_common: {
                    minlength: 1,
                    required: true
                },
                confirm_pwd_common: {
                    minlength: 1,
                    required: true,
                    equalTo: "#new_pwd_common"
                }
            },
            messages: {
                user_name_common: msg5,
                new_pwd_common: msg1,
                confirm_pwd_common: msg3



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
    };*/
    return {
        //main function to initiate template pages
        init: function() {
            runValidatorweeklySelection();
           
        }
    };
}();