var input_group_hide = $('#input_group_hide').val();
var input_group_showed = $.isEmptyObject(input_group_hide.trim());
$(function() {
    ValidateConfiguration.init();
});
var ValidateConfiguration = function() {
    if (input_group_showed) {
        $('.donation_percentage,.level_percentage').parent('.input-group').addClass('input-group-hide');
    }

    var runValidateConfiguration = function() {
        var msg6 = $("#validate_msg13").html();
        var msg7 = $("#validate_msg16").html();
        var msg8 = $("#validate_msg17").html();
        var msg17 = $("#validate_msg25").html();
        var msg19 = $("#validate_msg31").html();

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
        $('.level_percentage').each(function() {
            var msg_label = $(this).data('lang');
            $(this).rules('add', {
                number: true,
                min: 0,
                max: 100,
                required: true,
                messages: {
                    number: msg6,
                    min: msg6,
                    required: msg_label,
                    max: msg17,
                }
            });
        });
    };
    var runValidateConfig = function() {
        var msg9 = $("#upto_level_matching").html();
        var msg10 = $("#validate_msg30").html();
        var msg6 = $("#validate_msg13").html();

        var searchform = $('#form_setting1');
        var errorHandler1 = $('.errorHandler', searchform);

        var msg_label = $('#commission_upto_level').data('lang');
        $('#form_setting1').validate({
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
            rules: {
                commission_upto_level: {
                    required: true,
                    digits: true,
                    min: 1,
                    max: 100
                }
            },
            messages: {
                commission_upto_level: {
                    required: msg_label,
                    digits: msg6,
                    min: msg10,
                    max: msg9
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
    };
    return {
        //main function to initiate template pages
        init: function() {
            runValidateConfiguration();
            runValidateConfig();
        }
    };
}();