
var ValidateTicket = function () {

    ///////----for 'CHANGE USER PASSWORD' Tab - Begin/////////
    var runValidatorUserSelection = function () {

        var msg1 = $("#error_msg1").html();
        var msg2 = $("#error_msg2").html();
        var msg3 = $("#error_msg3").html();
        var msg4 = $("#error_msg4").html();
        var msg5 = $("#error_msg6").html();
        var msg6 = $("#error_msg8").html();
        jQuery.validator.addMethod("alpha_dash", function (value, element) {
            return this.optional(element) || /^[a-z0-9A-Z$@$!%*#?& _~\-!@#\$%\^&\*\(\)?,.:<>|\\+\/\[\]{}''"";`~=]*$/i.test(value);
        }, msg6);
        var searchform = $('#create_ticket');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#create_ticket').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                subject: {
                    minlength: 1,
                    required: true
                },
                priority: {
                    minlength: 1,
                    required: true,
                },
                category: {
                    minlength: 1,
                    required: true,
                },
                message: {
                    minlength: 1,
                    required: true
                }
            },
            messages: {
                subject: {required: msg1},
                priority: {required: msg2},
                category: {required: msg3},
                message: {required: msg4}

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
            runValidatorUserSelection();

        }
    };
}();

var ValidateViewTicket = function () {

    ///////----for 'CHANGE USER PASSWORD' Tab - Begin/////////
    var runValidatorUserSelection = function () {

        var msg1 = $("#error_msg5").html();

        var msg6 = $("#error_msg8").html();
        jQuery.validator.addMethod("alpha_dash", function (value, element) {
            return this.optional(element) || /^[a-z0-9A-Z$@$!%*#?& _~\-!@#\$%\^&\*\(\)?,.:<>|\\+\/\[\]{}''"";`~=]*$/i.test(value);
        }, msg6);
        var searchform = $('#view_ticket');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#view_ticket').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                ticket: {
                    minlength: 1,
                    required: true
                }

            },
            messages: {
                ticket: {required: msg1}


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
            runValidatorUserSelection();

        }
    };
}();
var ValidateTicketReplay = function () {
    ///////----for 'CHANGE USER PASSWORD' Tab - Begin/////////
    var runValidatorUserSelection = function () {

        var msg1 = $("#error_msg5").html();
        var msg4 = $("#error_msg4").html();

        var msg6 = $("#error_msg8").html();
        jQuery.validator.addMethod("alpha_dash", function (value, element) {
            return this.optional(element) || /^[a-z0-9A-Z$@$!%*#?& _~\-!@#\$%\^&\*\(\)?,.:<>|\\+\/\[\]{}''"";`~=]*$/i.test(value);
        }, msg6);
        var searchform = $('#reply_user');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#reply_user').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                message: {
                    minlength: 1,
                    required: true
                }

            },
            messages: {
                message: {required: msg4}


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
            runValidatorUserSelection();

        }
    };
}();

$(function () {
    ValidateTicket.init();
    ValidateTicketReplay.init();
    ValidateViewTicket.init();
});