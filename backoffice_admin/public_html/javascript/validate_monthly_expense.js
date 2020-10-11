

var ValidateExpense = function () {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg1").html();
    var msg1 = $("#error_msg2").html();
    var msg2 = $("#error_msg3").html();
    var msg3 = $("#error_msg4").html();
     var msg4 = $("#error_msg5").html();
    var runValidatorExpense = function () {
        var searchform = $('#form');
        var errorHandler1 = $('.errorHandler', searchform);
        $.validator.addMethod("zero", function (value, element) {
            if (value == 0)
                return false;
            return true;
        }, "Non zero digits only");
        $('#form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorId: 'form',
            errorPlacement: function (error, element) { // render error placement for each input type
                if ($(element).parent('.input-group').length === 0) {
                    error.insertAfter(element);
                }
                else {
                    error.insertAfter($(element).closest('.input-group'));
                }
            },
            ignore: ':hidden',
            rules: {
                amount: {
                    required: true,
                    maxlength: 10,
                    number: true,
                    zero: true
                },
                description: {
                    required: true,
                    maxlength:200
                }
            },
            messages: {
                amount: {
                    required: msg,
                    number: msg2,
                    maxlength:msg4
                },
                description: {
                    required: msg1
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
    var runValidatorMonthlySelection = function () {
        var searchform = $('#dateform');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#dateform').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorId: 'dateform',
            errorPlacement: function (error, element) { // render error placement for each input type
                if ($(element).parent('.input-group').length === 0) {
                    error.insertAfter(element);
                }
                else {
                    error.insertAfter($(element).closest('.input-group'));
                }
            },
            ignore: ':hidden',
            rules: {
                weekdate: {
                    required: true,
                }
            },
            messages: {
                weekdate: {
                    required: msg3
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

    return {
        //main function to initiate template pages
        init: function () {
            runValidatorExpense();
            runValidatorMonthlySelection();

        }
    };


}();