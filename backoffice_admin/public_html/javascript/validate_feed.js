//Added by Aparna
$(function () {
    ValidateUser.init();
})
$(document).ready(function () {
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#digit_msg").html();
    $("#phone_no").keypress(function (e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
            $("#errmsg1").html("<font color= '#b94a48'>" + msg4 + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });

    return true;

});

var ValidateUser = function () {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#error_msg4").html();
    var msg5 = $("#error_msg5").html();
    var msg8 = $("#error_msg8").html();
    var msg9 = $("#error_msg9").html();
    var msg10 = $("#error_msg10").html();
    var msg11 = $("#error_msg11").html();
    var msg12 = $("#error_msg12").html();
    var msg13 = $("#error_msg13").html();
    var msg14 = $("#error_msg14").html();
    var msg15 = $("#error_msg15").html();

    var runValidatorweeklySelection = function () {
        var searchform = $('#feedback_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $.validator.addMethod("time24", function (value, element) {
            if (!/^\d{2}:\d{2}:\d{2}$/.test(value))
                return false;
            var parts = value.split(':');
            if (parts[0] > 23 || parts[1] > 59 || parts[2] > 59)
                return false;
            return true;
        }, "Invalid time format.");
        $('#feedback_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                feedback_user: {
                    minlength: 1,
                    required: true
                },
                visitors_name: {
                    minlength: 1,
                    required: true,
                    maxlength: 32
                },
                company: {
                    minlength: 3,
                    maxlength: 32,
                    required: true
                },
                phone_no: {
                    minlength: 5,
                    required: true,
                    maxlength: 10
                            // equalTo: "#new_pwd_admin"
                },
                time_to_call: {
                    minlength: 1,
                    required: true,
//                    time24:true
                },
                comments: {
                    minlength: 1,
                    maxlength: 200,
                    required: true,
                },
                email: {
                    //minlength: 5,
                    maxlength: 50,
                    required: true,
                    email: true
                }
            },
            messages: {
                feedback_user: msg2,
                visitors_name: msg,
                company: {
                    required: msg1,
                    minlength: msg12,
                    maxlength: msg13
                },
                phone_no: {
                    required: msg3,
                    minlength: msg9,
                    maxlength: msg10
                },
                time_to_call: {
                    required: msg4,
//                    time24:"Invalid time format"
                },
                email: {
                    required: msg5,
                    email: msg11,
                    maxlength: msg14
                },
                comments: {
                    required: msg8,
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                errorHandler1.show();
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function (label, element) {
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
        init: function () {
            runValidatorweeklySelection();
            // runValidatePinConfig();
            // runValidatePinConfigAmount();

        }
    };
}();