$(function() {
    ValidateConfiguration.init();
    $('.select_rank').on('click', function() {
        var id = $(this).attr('id');
        $('#perc_div' + id).fadeToggle();
    });
});
var ValidateConfiguration = function() {
    var runValidateConfiguration = function() {
        var msg1 = $("#error_msg9").html();
        var msg2 = $("#error_msg5").html();
        var msg3 = $("#error_msg6").html();
        var msg4 = $("#error_msg7").html();
        var msg5 = $("#error_msg8").html();

        var searchform = $('#form_setting');
        var errorHandler1 = $('.errorHandler', searchform);
        var levels = $('.select_rank');
        var level_names = $.map(levels, function(e, i) {
            return $(e).attr("name")
        }).join(" ");
        var msg_label = $("#pool_bonus").data('lang');
        $('#form_setting').validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorId: 'err_config',
            errorPlacement: function(error, element) {
                if ($(element).closest('.checkbox').length) {
                    error.insertAfter($('.checkbox').last());
                } else if ($(element).parent('.input-group').length === 0) {
                    error.insertAfter(element);
                } else {
                    error.insertAfter($(element).closest('.input-group'));
                }
            },
            ignore: ':hidden',
            groups: {
                checks: level_names
            },
            rules: {
                pool_bonus: {
                    required: true,
                    number: true,
                    min: 0,
                    max: 100,
                }
            },
            messages: {
                pool_bonus: {
                    number: msg2,
                    min: msg4,
                    required: msg_label,
                    maxlength: msg3,
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
                form.submit();
            }
        });
        $('.level_percentage').each(function() {
            var msg_label = $(this).data('lang');
            $(this).rules('add', {
                number: true,
                min: 0,
                max: 100,
                required: true,
                valid_commission: true,
                messages: {
                    number: msg2,
                    min: msg4,
                    required: msg_label,
                    maxlength: msg3,
                    valid_commission: msg5,
                }
            });
        });
        $('.select_rank').each(function() {
            $(this).rules('add', {
                require_from_group: [1, ".select_rank"],
                messages: {
                    require_from_group: msg1,
                }
            });
        });
        $.validator.addMethod("valid_commission", function(value, element) {
            var total_pool = 0;
            $('.level_percentage:not(:hidden)').each(function() {
                total_pool += parseInt($(this).val()) || 0;
            });
            if (total_pool == 0) {
                return true;
            }
            if (total_pool <= 100) {
                return true;
            } else {
                return false;
            }
        });
    }

    return {
        //main function to initiate template pages
        init: function() {
            runValidateConfiguration();
        }
    };
}();