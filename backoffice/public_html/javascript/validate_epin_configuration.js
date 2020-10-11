$(function() {
    ValidateEpinConfiguration.init();
});
var ValidateEpinConfiguration = function() {

    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#error_msg4").html();
    var msg5 = $("#error_msg5").html();

    var runValidatePinConfig = function() {
        var searchform = $('#pin_config_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#pin_config_form').validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorPlacement: function(error, element) {

                error.insertAfter(element);
            },
            ignore: ':hidden',
            rules: {
                pin_maxcount: {
                    required: true,
                    digits: true,
                    min: 1
                }
            },
            messages: {
                pin_maxcount: {
                    required: msg1,
                    min: msg4,
                    digits: msg2
                },
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

    var runValidatePinConfigAmount = function() {
        var searchform = $('#epin_amount');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#epin_amount').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                if ($(element).parent('.input-group').length === 0) {
                    error.insertAfter(element);
                } else {
                    error.insertAfter($(element).closest('.input-group'));
                }
            },
            ignore: ':hidden',
            rules: {
                pin_amount: {
                    required: true,
                    number: true,
                    min: 0,
                    maxlength: 10
                }
            },
            messages: {
                pin_amount: {
                    required: msg3,
                    number: msg2,
                    min: msg2,
                    maxlength: msg5
                },
            },
            invalidHandler: function(event, validator) {
                errorHandler1.show();
            },
            highlight: function(element) {

                $(element).closest('.help-block').removeClass('valid');
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            success: function(label, element) {

                label.addClass('help-block valid');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });
    };

    return {
        //main function to initiate template pages
        init: function() {
            runValidatePinConfig();
            runValidatePinConfigAmount();

        }
    };
}();

function delete_epin(id) {
    var confirm_msg = $("#confirm_msg_delete").html();
    var path_root = $("#path_root").val();
    if (confirm(confirm_msg)) {
        document.location.href = path_root + 'admin/configuration/pin_config/delete/' + id;
    }
}

function delete_epins(id) {
    var confirm_msg = $("#confirm_msg_delete").html();
    var path_root = $("#path_root").val();
    if (confirm(confirm_msg)) {
        document.location.href = path_root + 'admin/configuration/pin_settings/delete/' + id;
    }
}