$(function() {
    ValidateConfiguration.init();
});
var ValidateConfiguration = function() {
    var runValidateConfiguration = function() {
        var msg1 = $("#error_msg3").html();
        var msg2 = $("#error_msg5").html();
        var msg3 = $("#error_msg6").html();
        var msg4 = $("#error_msg7").html();

        var searchform = $('#form_setting');
        var errorHandler1 = $('.errorHandler', searchform);

        $('#form_setting').validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorId: 'err_config',
            errorPlacement: function(error, element) {
                if ($(element).parent('.input-group').length === 0) {
                    error.insertAfter(element);
                } else {
                    error.insertAfter($(element).closest('.input-group'));
                }
            },
            ignore: ':hidden, .tab-content .tab-pane:not(.active) :input',
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
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
        $('.level_percentage').each(function() {
            $(this).rules('add', {
                number: true,
                min: 0,
                required: true,
                messages: {
                    number: msg2,
                    min: msg4,
                    required: msg1,
                    maxlength: msg3,
                }
            });
        });
    }

    return {
        //main function to initiate template pages
        init: function() {
            runValidateConfiguration();
        }
    };
}();