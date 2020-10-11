$(function () {
    ValidatePaypalConfig.init();
});
var ValidatePaypalConfig = function () {
    var msg1 = $("#validate_api_username").html();
    var msg2 = $("#validate_api_password").html();
    var msg3 = $("#validate_api_signature").html();
    var msg4 = $("#validate_mode").html();
    var msg51 = $("#validate_currency1").html();
    var msg52 = $("#validate_currency2").html();
    var msg53 = $("#validate_currency3").html();
    var msg54 = $("#validate_currency4").html();
    var msg6 = $("#validate_return_url").html();
    var msg7 = $("#validate_cancel_url").html();

    var runValidatePaypalConfig = function () {
        $.validator.addMethod("alpha_spec", function (value, element) {
            return this.optional(element) || value == value.match(/^[A-Z]+$/);
        }, msg54);
        var searchform = $('#payment_status_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#payment_status_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                api_username: {
                    required: true
                },
                api_password: {
                    required: true
                },
                api_signature: {
                    required: true
                },
                mode: {
                    required: true
                },
                currency: {
                    required: true,
                    maxlength: 3,
                    minlength: 3,
                    alpha_spec: true
                },
                return_url: {
                    required: true
                },
                cancel_url: {
                    required: true
                },
            },
            messages: {
                api_username: {
                    required: msg1
                },
                api_password: {
                    required: msg2
                },
                api_signature: {
                    required: msg3
                },
                mode: {
                    required: msg4
                },
                currency: {
                    required: msg51,
                    maxlength: msg52,
                    minlength: msg53,
                    alpha_spec: msg54
                },
                return_url: {
                    required: msg6
                },
                cancel_url: {
                    required: msg7
                },
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
    return {
        //main function to initiate template pages
        init: function () {
            runValidatePaypalConfig();

        }
    };
}();

var msg1 = $("#err_msg1").html();
var msg2 = $("#err_msg2").html();
var msg3 = $("#err_msg3").html();
var msg4 = $("#err_msg4").html();
var searchform = $('#payeer_configuration_form');
var errorHandler1 = $('.errorHandler', searchform);
$('#payeer_configuration_form').validate({
    errorElement: "span", // contain the error msg in a span tag
    errorClass: 'help-block',
    errorPlacement: function (error, element) { // render error placement for each input type
        error.insertAfter(element);
        // for other inputs, just perform default behavior
    },
    ignore: ':hidden',
    rules: {
        merchant_id: {
            required: true
        },
        merchant_key: {
            required: true
        },
        encryption_key: {
            required: true
        },
        account: {
            required: true
        },
    },
    messages: {
        merchant_id: {
            required: msg1
        },
        merchant_key: {
            required: msg2
        },
        encryption_key: {
            required: msg3
        },
        account: {
            required: msg4
        },
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