$(function()
{
    ValidateSmsSettings.init();
    ValidateMailSettings.init();
    ValidateMailGunSettings.init();
});
var ValidateSmsSettings = function() {

    var msg1 = $("#validate_msg1").html();
    var msg2 = $("#validate_msg2").html();
    var msg3 = $("#validate_msg3").html();

    var runValidateSmsSettings = function() {

        var searchform = $('#sms_form');
        var errorHandler1 = $('.errorHandler', searchform);
        //var successHandler1 = $('.successHandler', form_setting);
        $('#sms_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type
                if ($(element).hasClass("date-picker")) {
                    error.insertAfter($(element).closest('.input-group'));
                }
                else
                {
                    error.insertAfter(element);
                }
                ;
                //error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                sender_id: {
                    minlength: 1,
                    required: true
                },
                user_name: {
                    minlength: 1,
                    required: true
                },
                password: {
                    minlength: 1,
                    required: true
                }
            },
            messages: {
                sender_id: msg1,
                user_name: msg2,
                password: msg3

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
            runValidateSmsSettings();

        }
    };

}();


var ValidateMailSettings = function() {

    var msg1 = $("#validate_msg1").html();
    var msg2 = $("#validate_msg2").html();
    var msg3 = $("#validate_msg3").html();
    var msg4 = $("#validate_msg4").html();
    var msg5 = $("#validate_msg5").html();
    var msg6 = $("#validate_msg6").html();
    var msg7 = $("#validate_msg7").html();
    var msg71 = $("#validate_msg71").html();
    var msg8 = $("#validate_msg8").html();
    var msg9 = $("#validate_msg9").html();
    var msg10 = $("#validate_msg10").html();

    var runValidateLetterConfig = function() {

        var searchform = $('#mail_settings');
        var errorHandler1 = $('.errorHandler', searchform);
        //var successHandler1 = $('.successHandler', form_setting);
        $('#mail_settings').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type
                if ($(element).hasClass("date-picker")) {
                    error.insertAfter($(element).closest('.input-group'));
                } else if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
                    error.insertAfter($(element).closest('.checkbox-inline'));
                } else
                {
                    error.insertAfter(element);
                }
                ;
                //error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                from_name: {
                    minlength: 1,
                    required: true
                },
                from_email: {
                    minlength: 1,
                    required: true
                },
                smtp_host: {
                    minlength: 1,
                    required: true
                },
                smtp_username: {
                    minlength: 1,
                    required: true
                },
                smtp_password: {
                    minlength: 1,
                    required: true
                },
                smtp_port: {
                    minlength: 1,
                    required: true,
                    number: true
                },
                smtp_timeout: {
                    minlength: 1,
                    required: true,
                    number: true
                },
                reg_mail_status: {
                    minlength: 1,
                    required: true
                },
                smtp_auth_type: {
                    required: true
                },
                smtp_protocol: {
                    required: true
                }
            },
            messages: {
                from_name: {
                    required: msg1
                },
                from_email: {
                    required: msg2
                },
                smtp_host: {
                    required: msg3
                },
                smtp_username: {
                    required: msg4
                },
                smtp_password: {
                    required: msg5
                },
                smtp_port: {
                    required: msg6,
                    number: msg71
                },
                smtp_timeout: {
                    required: msg7,
                    number: msg71
                },
                reg_mail_status: {
                    required: msg8
                },
                smtp_auth_type: {
                    required: msg9
                },
                smtp_protocol: {
                    required: msg10
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
            runValidateLetterConfig();

        }
    };

}();


var ValidateGeneralMailSettings = function() {
    var msg1 = $("#validate_msg1").html();
    var msg2 = $("#validate_msg2").html();

    var runValidateLetterConfig = function() {
        var searchform = $('#mail_settings');
        var errorHandler1 = $('.errorHandler', searchform);
        //var successHandler1 = $('.successHandler', form_setting);
        $('#mail_settings').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type
//				if ($(element).hasClass("date-picker") ) {
//				 error.insertAfter($(element).closest('.input-group'));
//				}
//				else
//				{
//				 error.insertAfter(element);
//				};
                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                send_from: {
                    minlength: 1,
                    email: true,
                    required: true
                }
            },
            messages: {
                send_from: {required: msg1, email: msg2}
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
            runValidateLetterConfig();

        }
    };

}();

var ValidateMailGunSettings = function() {

    var msg1 = $("#validate_msg1").html();
    var msg2 = $("#validate_msg2").html();
    var msg11 = $("#validate_msg11").html();
    var msg12 = $("#validate_msg12").html();
    var msg13 = $("#validate_msg13").html();
    var msg14 = $("#validate_msg14").html();
    var msg15 = $("#validate_msg15").html();
    var msg16 = $("#validate_msg16").html();

    var runValidateMailGunConfig = function() {

        var searchform = $('#mail_gun_settings');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#mail_gun_settings').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type
                if ($(element).hasClass("date-picker")) {
                    error.insertAfter($(element).closest('.input-group'));
                } else if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
                    error.insertAfter($(element).closest('.checkbox-inline'));
                } else
                {
                    error.insertAfter(element);
                }
                ;
            },
            ignore: ':hidden',
            rules: {
                from_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 32
                },
                from_email: {
                    minlength: 1,
                    required: true,
                    email: true
                },
                reply_to: {
                    minlength: 1,
                    required: true,
                    email: true
                },
                domain: {
                    required: true,  
                   minlength: 3,
                    maxlength: 32
                },
                api_key:{
                    required: true,  
                    minlength: 3,
                    maxlength: 32
                }
                
            },
            messages: {
                from_name: {
                    required: msg1,
                    minlength: msg15,
                    maxlength: msg16
                },
                from_email: {
                    required: msg2,
                    email: msg14
                },
                reply_to: {
                    required: msg11,
                    email: msg14
                },
                domain: {
                    required: msg12,
                    minlength: msg15,
                    maxlength: msg16
                },
                api_key:{
                    required: msg13,
                    minlength: msg15,
                    maxlength: msg16
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
        init: function() {
            runValidateMailGunConfig();

        }
    };

}();

