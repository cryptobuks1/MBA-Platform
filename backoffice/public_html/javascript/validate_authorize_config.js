var ValidateAuthorizeConfig = function () {

    var runValidatorAuthorizeSelection = function () {

        var msg4 = $("#validate_msg1").html();
        var msg5 = $("#validate_msg2").html();
        var searchform = $('#authorize_status_form');
        var errorHandler1 = $('.errorHandler', searchform);

        $('#authorize_status_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                merchant_log_id: {
                    minlength: 1,
                    required: true
                },
                transaction_key: {
                    minlength: 1,
                    required: true
                }
            },
            messages: {
                merchant_log_id: msg5,
                transaction_key: msg4
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
            runValidatorAuthorizeSelection();
        }
    };
}();
(function () {
        ValidateAuthorizeConfig.init();
});