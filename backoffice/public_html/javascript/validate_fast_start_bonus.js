var input_group_hide = $('#input_group_hide').val();
var input_group_showed = $.isEmptyObject(input_group_hide.trim());
$(function () {
    $('input[name="fast_start_referral_count"],input[name="fast_start_days"],input[name="fast_start_bonus"]').attr('maxlength', 5);
    ValidateConfiguration.init();

});
var ValidateConfiguration = function () {
    var runValidateConfiguration = function () {
        var msg6 = $("#validate_msg13").html();
        var msg26 = $("#validate_msg26").html();
        var msg30 = $("#validate_msg30").html();
        var bonus_amount = $("#lang_bonus_amount").html();
        var referral_count = $("#lang_referral_count").html();
        var days = $("#lang_days").html();

        var searchform = $('#form_setting');
        var errorHandler1 = $('.errorHandler', searchform);

        $('#form_setting').validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorId: 'err_config',
            errorPlacement: function (error, element) {
                if ($(element).parent('.input-group').length === 0) {
                    error.insertAfter(element);
                } else {
                    error.insertAfter($(element).closest('.input-group'));
                }
            },
            ignore: ':hidden',
            rules: {
                fast_start_referral_count: {
                    required: true,
                    digits: true,
                    min: 1,
                },
                fast_start_days: {
                    required: true,
                    digits: true,
                    min: 1,
                },
                fast_start_bonus: {
                    required: true,
                    min: 0,
                }
            },
            messages: {
                fast_start_referral_count: {
                    required: msg26.replace('%s', referral_count),
                    digits: msg30,
                    min: msg30,
                },
                fast_start_days: {
                    required: msg26.replace('%s', days),
                    digits: msg30,
                    min: msg30,
                },
                fast_start_bonus: {
                    required: msg26.replace('%s', bonus_amount),
                    min: msg6,
                }
            },
            invalidHandler: function () {
                errorHandler1.show();
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');

                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');

            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    };

    return {
        init: function () {
            runValidateConfiguration();
        }
    };
}();
