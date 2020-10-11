$(function() {
    ValidateConfiguration.init();
});

var ValidateConfiguration = function() {

    var runValidatorStairStepConfig = function() {

        var msg1 = $("#error_msg1").html();
        var msg2 = $("#error_msg2").html();
        var msg3 = $("#error_msg3").html();
        var msg4 = $("#error_msg4").html();
        var msg5 = $("#error_msg5").html();
        var msg6 = $("#error_msg6").html();
        var msg7 = $("#error_msg7").html();

        var searchform = $('#stair_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#stair_form').validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            },
            ignore: ':hidden',
            rules: {
                step_name: {
                    minlength: 1,
                    required: true
                },
                personal_pv: {
                    minlength: 1,
                    required: true,
                    number: true
                },
                group_pv: {
                    minlength: 1,
                    required: true,
                    number: true
                },
                step_commission: {
                    minlength: 1,
                    required: true,
                    number: true
                },
                override_commission: {
                    minlength: 1,
                    required: true,
                    number: true
                }
            },
            messages: {
                step_name: msg1,
                personal_pv: {
                    required: msg2,
                    number: msg7
                },
                group_pv: {
                    required: msg3,
                    number: msg7
                },
                step_commission: {
                    required: msg4,
                    number: msg7
                },
                override_commission: {
                    required: msg5,
                    number: msg7
                }
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
    var runValidatorStairStepOverride = function() {
        var msg5 = $("#error_msg5").html();
        var msg7 = $("#error_msg7").html();
        var msg8 = $("#error_msg8").html();

        var searchform2 = $('#stair_form1');
        var errorHandler2 = $('.errorHandler', searchform2);
        $('#stair_form1').validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            },
            ignore: ':hidden',
            rules: {
                override_commission: {
                    minlength: 1,
                    required: true,
                    number: true,
                    min: 0,
                    max: 100,
                }
            },
            messages: {
                override_commission: {
                    required: msg8,
                    number: msg7,
                    min: msg5,
                    max: msg5
                }
            },
            invalidHandler: function(event, validator) {
                errorHandler2.show();
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
    }

    return {
        //main function to initiate template pages
        init: function() {
            runValidatorStairStepConfig();
            runValidatorStairStepOverride();
        }
    };
}();