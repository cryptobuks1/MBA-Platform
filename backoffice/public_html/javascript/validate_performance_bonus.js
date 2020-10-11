var input_group_hide = $('#input_group_hide').val();
var input_group_showed = $.isEmptyObject(input_group_hide.trim());
$(function() {
    $('input.performance_personal_pv,input.performance_group_pv,input.performance_bonus_percent').attr('maxlength', 5);
    ValidateConfiguration.init();
});
var ValidateConfiguration = function() {

    var runValidateConfiguration = function() {
        var msg26 = $("#validate_msg26").html();
        var msg27 = $("#validate_msg27").html();
        var msg29 = $("#validate_msg29").html();
        var bonus = $("#lang_bonus").html();
        var personal_pv = $("#lang_personal_pv").html();
        var group_pv = $("#lang_group_pv").html();
        var msg6 = $("#validate_msg13").html();

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
                var demo_status = $('#demo_status').val();
                if (document.getElementById('cleanup_flag').value == 1 && demo_status == 'yes') {
                    if (confirm($("#update_plan_confirm_msg").html())) {
                        $("#cleanup_flag").val("do_clean");
                        form.submit();
                    }
                } else {
                    form.submit();
                }
            }
        });
        $('.performance_personal_pv').each(function() {
            $(this).rules('add', {
                required: true,
                number: true,
                min: 0,
                messages: {
                    required: msg26.replace('%s', personal_pv),
                    min: msg29.replace('%s', personal_pv),
                    number: msg6,
                }
            });
        });
        $('.performance_group_pv').each(function() {
            $(this).rules('add', {
                required: true,
                number: true,
                min: 0,
                messages: {
                    required: msg26.replace('%s', group_pv),
                    min: msg29.replace('%s', group_pv),
                    number: msg6,
                }
            });
        });
        $('.performance_bonus_percent').each(function() {
            $(this).rules('add', {
                required: true,
                min: 0,
                number: true,
                max: 100,
                messages: {
                    required: msg26.replace('%s', bonus),
                    min: msg27.replace('%s', bonus),
                    max: msg27.replace('%s', bonus),
                    number: msg6,
                }
            });
        });
    };

    return {
        //main function to initiate template pages
        init: function() {
            runValidateConfiguration();
        }
    };
}();