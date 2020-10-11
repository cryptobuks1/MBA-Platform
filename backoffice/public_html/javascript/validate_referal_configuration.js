var input_group_hide = $('#input_group_hide').val();
var input_group_showed = $.isEmptyObject(input_group_hide.trim());
$(function() {
    $('.tab').find('.content').find('.form-group:last').find('button[type="submit"]').parent().next('hr.new_line').remove();
    $("#referal_amount").inputFilter(function (value) {
        return /^\d*[.]?\d*$/.test(value);
    });
    ValidateConfiguration.init();

    $('#sponsor_commission_type').on('change', function() {
        if ($(this).val() == "rank") {
            $('#referal_rank_div').show();
            $('#referal_package_div').hide();
        } else {
            $('#referal_package_div').show();
            $('#referal_rank_div').hide();
        }
    });
    $('#sponsor_commission_type').trigger("change");
    $("#referal_commission_type").change();
});
var ValidateConfiguration = function() {
    $("#referal_commission_type").change(function() {
        if ($(this).val() === 'percentage') {
            if (input_group_showed) {
                $('.level_percentage').parent('.input-group').addClass('input-group-hide');
            }
        } else {
            if (input_group_showed) {
                $('.level_percentage').parent('.input-group').removeClass('input-group-hide');
            }
        }
    });

    function findProperty(obj, key) {
        if (typeof obj === "object") {
            if (key in obj) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    var runValidateConfiguration = function() {
        var msg6 = $("#validate_msg13").html();
        var msg17 = $("#validate_msg25").html();
        var msg18 = $("#validate_msg30").html();
        var msg19 = $("#validate_msg31").html();
        var msg26 = $("#validate_msg26").html();
        var referral_comm = $("#lang_referral_comm").html();

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
            rules: {
                referal_amount: {
                    required: true
                }
            },
            messages: {
                referal_amount: {
                    required: msg26.replace('%s', referral_comm)
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
        $('.level_percentage').each(function() {
            var msg_label = $(this).data('lang');
            $(this).rules('add', {
                number: true,
                min: 0,
                required: true,
                messages: {
                    number: msg6,
                    min: msg18,
                    required: msg_label,
                    maxlength: msg19,
                }
            });
            if ($("#sponsor_commission_type").val() === 'percentage') {
                $('.level_percentage').each(function() {
                    $(this).rules('add', {
                        max: 100,
                        messages: {
                            max: msg17
                        }
                    });
                });
            }
            $("#referal_commission_type").change(function() {
                if ($(this).val() === 'percentage') {
                    $('.level_percentage').each(function() {
                        $(this).rules('add', {
                            max: 100,
                            messages: {
                                max: msg17
                            }
                        });
                    });
                } else {
                    $('.level_percentage').each(function() {
                        var rules = $(this).rules();
                        if (findProperty(rules, 'max')) {
                            $(this).rules('remove', 'max');
                        }
                    });
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

function setHiddenValue(tab) {
    $("#active_tab").val(tab);
}

function change_referal_commission_type(val) {
    if (val == 'percentage') {
        $(".span_level_commission").html("(%)");
    } else {
        $(".span_level_commission").html('');
    }
}