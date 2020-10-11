var input_group_hide = $('#input_group_hide').val();
var input_group_showed = $.isEmptyObject(input_group_hide.trim());
$(function() {
    $('.tab').find('.content').find('.form-group:last').find('button[type="submit"]').parent().next('hr.new_line').remove();
    $('input.matching_level,input[name="pool_bonus"],input.pool_level,input[name="fast_start_referral_count"],input[name="fast_start_days"],input[name="fast_start_bonus"],input.performance_personal_pv,input.performance_group_pv,input.performance_bonus_percent').attr('maxlength', 5);
    if ($('#current_url').val() == 'configuration/kyc_configuration') {
        ValidateKycConfiguration.init();
    }
    ValidateConfiguration.init();

    $("input[name='pair_commission_type']").change();
    $("input[name='level_commission_type']").change();
    $("select[name='pair_ceiling_type']").change();
    $('#pair_ceiling').on('blur', function() {
        $('#pair_ceiling_monthly').valid();
    });

    additionalBonusConfig();

});
var ValidateConfiguration = function() {

    $("input[name='level_commission_type']").change(function() {
        if ($("input[name='level_commission_type']:checked").val() === 'percentage') {
            if (input_group_showed) {
                $('.donation_percentage,.level_percentage').parent('.input-group').addClass('input-group-hide');
            }
            $('.donation_percentage').each(function() {
                $(this).rules('add', {
                    max: 100,
                    messages: {
                        max: "Commission value must be between 0 to 100"
                    }
                });
            });
        } else {
            if (input_group_showed) {
                $('.donation_percentage,.level_percentage').parent('.input-group').removeClass('input-group-hide');
            }
            $('.donation_percentage').each(function() {
                var rules = $(this).rules();
                if (findProperty(rules, 'max')) {
                    $(this).rules('remove', 'max');
                }
            });
        }
    });
    $("input[name='pair_commission_type']").change(function() {
        if ($("input[name='pair_commission_type']:checked").val() === 'percentage') {
            if (input_group_showed) {
                $('#pair_price').parent('.input-group').addClass('input-group-hide');
            }
        } else {
            if (input_group_showed) {
                $('#pair_price').parent('.input-group').removeClass('input-group-hide');
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

    function checktaxes(tds, service_charge) {
        return ((tds + service_charge) <= 100);
    }

    var runValidateConfiguration = function() {
        var msg4 = $("#validate_msg1").html();
        var msg5 = $("#validate_msg2").html();
        var msg6 = $("#validate_msg13").html();
        var msg7 = $("#validate_msg16").html();
        var msg8 = $("#validate_msg17").html();
        var msg9 = $("#validate_msg18").html();
        var msg10 = $("#validate_msg12").html();
        var msg11 = $("#validate_msg19").html();
        var msg12 = $("#validate_msg20").html();
        var msg13 = $("#validate_msg21").html();
        var msg14 = $("#validate_msg22").html();
        var msg15 = $("#validate_msg23").html();
        var msg16 = $("#validate_msg24").html();
        var msg17 = $("#validate_msg25").html();
        var msg26 = $("#validate_msg26").html();
        var msg27 = $("#validate_msg27").html();
        var msg28 = $("#validate_msg28").html();
        var msg29 = $("#validate_msg29").html();
        var msg30 = $("#validate_msg30").html();
        var msg31 = $("#pair_ceiling_count_span").html();
        var msg32 = $("#pair_ceiling_count_required").html();
        var msg33 = $("#pair_value_required").html();
        var msg34 = $("#depth_ceiling_required").html();
        var msg35 = $("#registration_amount_required").html();
        var msg36 = $("#trans_fee_required").html();
        var msg37 = $("#you_must_enter").html();
        var level_n_bonus = $("#level_n_bonus").html();
        var bonus = $("#lang_bonus").html();
        var personal_pv = $("#lang_personal_pv").html();
        var group_pv = $("#lang_group_pv").html();
        var bonus_amount = $("#lang_bonus_amount").html();
        var referral_count = $("#lang_referral_count").html();
        var days = $("#lang_days").html();
        var board1_name = $("#board1_name").html();
        var board1_width = $("#board1_width").html();
        var board1_depth = $("#board1_depth").html();
        var table_name = $("#table_name").html();
        var table_width = $("#table_width").html();
        var table_depth = $("#table_depth").html();
        var board1_commission = $("#board1_commission").html();
        var table_commission = $("#table_commission").html();
        var override_commission = $("#override_required").html();
        var purchase_income_perc = $("#purchase_income_perc_required").html();

        var searchform = $('#form_setting');
        var errorHandler1 = $('.errorHandler', searchform);

        $.validator.addMethod("valid_taxes", function(value, element) {
            var tds = parseInt($('#tds').val());
            var service_charge = parseInt($('#service').val());
            var total_tax = tds + service_charge;
            if (total_tax == 0) {
                return true;
            }
            var res = checktaxes(tds, service_charge);
            if (res == true) {
                return true;
            } else {
                return false;
            }
        });

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
                pair_ceiling_type: {
                    minlength: 1,
                    required: true
                },
                pair_value: {
                    required: true
                },
                depth_ceiling: {
                    minlength: 1,
                    digits: true,
                    required: true
                },
                xup_level: {
                    required: true,
                    digits: true,
                    min: 1,
                    max: 3
                },
                pool_bonus: {
                    required: true,
                    min: 0,
                    max: 100,
                },
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
                },
                override_commission: {
                    required: true,
                    min: 0,
                    max: 100,
                    digits: true
                }
            },
            messages: {
                xup_level: {
                    required: msg11,
                    digits: msg6,
                    min: msg10,
                    max: msg9
                },
                merchant_log_id: msg5,
                transaction_key: msg4,
                pair_value: msg33,
                depth_ceiling: msg34,
                pool_bonus: {
                    required: msg26.replace('%s', bonus),
                    min: msg27.replace('%s', bonus),
                    max: msg27.replace('%s', bonus),
                },
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
                },
                override_commission: {
                    required: msg37 + ' ' + override_commission,
                    min: msg27.replace('%s', override_commission),
                    max: msg27.replace('%s', override_commission)
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
        $('.board_name').each(function() {
            var level = $(this).data('level');
            var label = board1_name.replace('%s', level);
            var msg_required = msg37 + ' ' + label;
            $(this).rules('add', {
                required: true,
                maxlength: 15,
                messages: {
                    required: msg_required
                }
            });
        });
        $('.board_width').each(function() {
            var level = $(this).data('level');
            var label = board1_width.replace('%s', level);
            var msg_required = msg37 + ' ' + label;
            $(this).rules('add', {
                required: true,
                maxlength: 1,
                messages: {
                    required: msg_required
                }
            });
        });
        $('.board_depth').each(function() {
            var level = $(this).data('level');
            var label = board1_depth.replace('%s', level);
            var msg_required = msg37 + ' ' + label;
            $(this).rules('add', {
                required: true,
                maxlength: 1,
                messages: {
                    required: msg_required
                }
            });
        });
        $('.table_name').each(function() {
            var level = $(this).data('level');
            var label = table_name.replace('%s', level);
            var msg_required = msg37 + ' ' + label;
            $(this).rules('add', {
                required: true,
                maxlength: 15,
                messages: {
                    required: msg_required
                }
            });
        });
        $('.table_width').each(function() {
            var level = $(this).data('level');
            var label = table_width.replace('%s', level);
            var msg_required = msg37 + ' ' + label;
            $(this).rules('add', {
                required: true,
                maxlength: 1,
                messages: {
                    required: msg_required
                }
            });
        });
        $('.table_depth').each(function() {
            var level = $(this).data('level');
            var label = table_depth.replace('%s', level);
            var msg_required = msg37 + ' ' + label;
            $(this).rules('add', {
                required: true,
                maxlength: 1,
                messages: {
                    required: msg_required
                }
            });
        });
        $('.table_comm').each(function() {
            var level = $(this).data('level');
            var label = table_commission.replace('%s', level);
            var msg_required = msg37 + ' ' + label;
            $(this).rules('add', {
                required: true,
                maxlength: 5,
                digits: true,
                messages: {
                    required: msg_required,
                    maxlength: $("#max_5").html()
                }
            });
        });
        $('.matching_level').each(function() {
            var level = $(this).data('level');
            var label = level_n_bonus.replace('%s', level);
            var msg_required = msg37 + ' ' + label;
            var msg_min_max = msg27.replace('%s', label);
            $(this).rules('add', {
                required: true,
                min: 0,
                max: 100,
                messages: {
                    required: msg_required,
                    min: msg_min_max,
                    max: msg_min_max,
                }
            });
        });
        $('.pool_level').each(function() {
            var level = $(this).data('level');
            var label = level_n_bonus.replace('%s', level);
            var msg_required = msg26.replace('%s', label);
            var msg_min_max = msg27.replace('%s', label);
            $(this).rules('add', {
                required: true,
                min: 0,
                max: 100,
                messages: {
                    required: msg_required,
                    min: msg_min_max,
                    max: msg_min_max,
                }
            });
        });
        $('.performance_personal_pv').each(function() {
            $(this).rules('add', {
                required: true,
                min: 0,
                messages: {
                    required: msg26.replace('%s', personal_pv),
                    min: msg29.replace('%s', personal_pv),
                }
            });
        });
        $('.performance_group_pv').each(function() {
            $(this).rules('add', {
                required: true,
                min: 0,
                messages: {
                    required: msg26.replace('%s', group_pv),
                    min: msg29.replace('%s', group_pv),
                }
            });
        });
        $('.performance_bonus_percent').each(function() {
            $(this).rules('add', {
                required: true,
                min: 0,
                max: 100,
                messages: {
                    required: msg26.replace('%s', bonus),
                    min: msg27.replace('%s', bonus),
                    max: msg27.replace('%s', bonus),
                }
            });
        });
        $('.level_percentage').each(function() {
            var msg_label = $(this).data('lang');
            $(this).rules('add', {
                number: true,
                min: 0,
                required: true,
                messages: {
                    number: msg6,
                    min: msg6,
                    required: msg_label,
                }
            });
            if ($("input[name='level_commission_type']:checked").val() === 'percentage') {
                $('.level_percentage').each(function() {
                    $(this).rules('add', {
                        max: 100,
                        messages: {
                            max: msg17
                        }
                    });
                });
            }
            $("input[name='level_commission_type']").change(function() {
                if ($("input[name='level_commission_type']:checked").val() === 'percentage') {
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
        $('.donation_percentage').each(function() {
            $(this).rules('add', {
                required: true,
                number: true,
                min: 0,
                maxlength: 15,
                messages: {
                    required: msg7,
                    number: msg6,
                    min: msg6,
                    maxlength: msg8
                }
            });
        });

        $('#tds,#service').on('change', function() {
            if (this.value) {
                $('#tds').valid();
                $('#service').valid();
            }
        });

    };

    return {
        //main function to initiate template pages
        init: function() {
            runValidateConfiguration();
        }
    };
}();



$(document).ready(function() {
    var msg = $("#error_msg3").html();
    var msg1 = $("#validate_msg4").html();
    var msg2 = $("#validate_msg13").html();
    var msg3 = $("#validate_msg12").html();
    var msg4 = $("#validate_msg14").html();

    $("#service").keypress(function(e) {
        var flag = 0;
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                flag = 1;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) {
            flag = 1;
        }
        if (flag == 1) {
            //display error message
            $("#errmsg1").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(2200, 0);
            return false;
        }
    });
    $("#tds").keypress(function(e) {
        var flag = 0;
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                flag = 1;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) {
            flag = 1;
        }
        if (flag == 1) {
            //display error message
            $("#errmsg2").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#pair").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#errmsg3").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(2200, 0);
            return false;
        }
    });
    $("#ceiling").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#errmsg4").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(2200, 0);
            return false;
        }
    });
    $("#referal_amount").keypress(function(e) {
        var flag = 0;
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                flag = 1;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) {
            flag = 1;
        }
        if (flag == 1) {
            //display error message
            $("#errmsg6").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }

    });
    $("#reg_amount").keypress(function(e) {
        var flag = 0;
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                flag = 1;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) {
            flag = 1;
        }
        if (flag == 1) { //display error message
            $("#errmsg3").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#purchase_income_perc").keypress(function(e) {
        var flag = 0;
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                flag = 1;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) {
            flag = 1;
        }
        if (flag == 1) { //display error message
            $("#errmsg3").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#trans_fee").keypress(function(e) {
        var flag = 0;
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                flag = 1;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) {
            flag = 1;
        }
        if (flag == 1) {
            //display error message
            $("#errmsg7").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#pair_ceiling").keypress(function(e) {
        var msg = $("#validate_msg15").html();
        var value = document.getElementById('pair_ceiling').value;
        if (value.length >= 5 && e.which != 8) {
            $("#errmsg8").html(msg).show().fadeOut(1200, 0);
            return false;
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#errmsg8").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#pair_ceiling_monthly").keypress(function(e) {
        var msg = $("#validate_msg15").html();
        var value = document.getElementById('pair_ceiling_monthly').value;
        if (value.length >= 5 && e.which != 8) {
            $("#errmsg8").html(msg).show().fadeOut(1200, 0);
            return false;
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#errmsg8").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#pair_value").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which == 46) {
            if ($(this).val().indexOf('.') != -1) {
                $("#errmsg9").html(msg2).show().fadeOut(1200, 0);
                return false;
            }
        }
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) {
            //(event.which != 46 && $(this).val().indexOf('.') == 0)
            //display error message
            $("#errmsg9").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#depth_ceiling").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#errmsg10").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#pair_price").keypress(function(e) {
        if (e.which == 46) {
            if ($(this).val().indexOf('.') > 0) {
                $("#errmsg11").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
                return false;
            }
        }
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) {
            //display error message
            $("#errmsg11").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#width_ceiling").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#errmsg12").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#product_point_value").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#errmsg13").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#length").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#errmsg1").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });


    $("#board1_commission").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#errmsg4").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#board2_commission").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#errmsg5").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });

    $("#sort_order").keypress(function(e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            var msg = $("#validate_msg13").html();
            $("#errmsg1").html("<font color= '#b94a48'>" + msg2 + "</font>").show().fadeOut(1200, 0);
            return false;
        }
    });
    var board_count = $("#board_count").val();
    for (var i = 0; i < board_count; i++) {
        $("#board" + i + "_width").keypress(function(e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                $(this).next().html(msg2).show().fadeOut(1200, 0);
                return false;
            }
        });

        $("#board" + i + "_depth").keypress(function(e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                $(this).next().html(msg2).show().fadeOut(1200, 0);
                return false;
            }
        });

        $("#board" + i + "_name").keypress(function(e) {
            var flag = /[a-z0-9 ]/i.test(
                String.fromCharCode(e.charCode || e.keyCode)
            ) || !e.charCode && e.keyCode < 48;
            if (!flag) {
                $(this).next().html(msg4).show().fadeOut(1200, 0);
                return false;
            }
        });
    }
});

function setHiddenValue(tab) {
    $("#active_tab").val(tab);
}

function change_pair_ceiling_visibility(val) {
    var pair_commission_type = $('#db_pair_commission_type').val();
    $('#pair_ceiling_month_div').hide();
    if (val == 'none') {
        $('#pair_ceiling_div').hide();
    } else {
        $('#pair_ceiling_div').show();
        $('#pair_ceiling').rules('remove');
        var msg26 = $("#validate_msg26").html();
        var msg31 = $("#validate_msg31").html();
        if (val == 'monthly_with_daily') {
            $('#pair_ceiling_month_div').show();
            if (pair_commission_type == 'flat') {
                var label1 = $('#lang_pair_ceiling_daily_count').text();
                var label2 = $('#lang_pair_ceiling_monthly_count').text();

            } else {
                var label1 = $('#lang_pair_ceiling_daily_pv').text();
                var label2 = $('#lang_pair_ceiling_monthly_pv').text();
            }
            $('#pair_ceiling_div').find('label').not(':hidden').text(label1);
            $('#pair_ceiling_month_div').find('label').not(':hidden').text(label2);
            $('#pair_ceiling_monthly').rules('remove');
            var msg1 = ((label1).toLowerCase()).replace('pv', 'PV');
            var msg2 = ((label2).toLowerCase()).replace('pv', 'PV');
            $('#pair_ceiling').rules('add', {
                minlength: 1,
                digits: true,
                required: true,
                messages: {
                    required: msg26.replace('%s', msg1),
                }
            });
            $('#pair_ceiling_monthly').rules('add', {
                minlength: 1,
                digits: true,
                required: true,
                greaterThanEqual: '#pair_ceiling',
                messages: {
                    required: msg26.replace('%s', msg2),
                    greaterThanEqual: msg31.replace('{field1}', msg2).replace('{field2}', msg1),
                }
            });
        } else {
            if (pair_commission_type == 'flat') {
                var label = $('#lang_pair_ceiling_count').text();
            } else {
                var label = $('#lang_pair_ceiling_pv').text();
            }
            $('#pair_ceiling_div').find('label').not(':hidden').text(label);
            var msg = ((label).toLowerCase()).replace('pv', 'PV');
            $('#pair_ceiling').rules('add', {
                minlength: 1,
                digits: true,
                required: true,
                messages: {
                    required: msg26.replace('%s', msg),
                }
            });
        }
    }
}

function change_pair_value_visibility(val) {
    return;
    var default_symbol = document.getElementById('project_default_symbol').value;
    if (val == 'percentage') {
        document.getElementById('pair_value_div').style.display = "none";
        document.getElementById('pair_ceiling_pv_label').style.display = "block";
        document.getElementById('pair_ceiling_count_label').style.display = "none";
        $(".span_pair_commission").html("(%)");
    } else {
        document.getElementById('pair_value_div').style.display = "block";
        document.getElementById('pair_ceiling_pv_label').style.display = "none";
        document.getElementById('pair_ceiling_count_label').style.display = "block";
        $(".span_pair_commission").html('');
    }
}

function change_level_commission_type(val) {
    var default_symbol = document.getElementById('project_default_symbol').value;
    if (val == 'percentage') {
        $(".span_level_commission").html("(%)");
    } else {
        $(".span_level_commission").html('');
    }
}

function changeBoardVisibility(status, num) {
    var board_count = $("#board_count").val();
    if (status == 'no') {
        for (var i = num + 1; i < board_count; i++) {
            document.getElementById('board' + i).style.display = "none";
        }
    } else {
        num += 1;
        document.getElementById('board' + num).style.display = "block";
    }
}

function set_cleanup_flag(current_value, new_value) {
    var cleanup_flag = document.getElementById('cleanup_flag').value;
    if (current_value != new_value && cleanup_flag != 1) {
        $("#cleanup_flag").val("1");
    }
}


function change_module_status(path_temp, path_root, module_name, module_status) {
    var set_module_status = path_root + "configuration/change_module_status";
    var msg = $("#load_msg").html();
    $("#" + module_name).removeClass();
    $("#" + module_name).addClass('messagebox');
    $("#" + module_name).html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" />' + msg).show().fadeTo(1900, 1);
    $.post(set_module_status, { module_name: module_name, module_status: module_status }, function(data) {
        location.reload();
    });
}

function change_credit_card_status(path_root, id, module_status) {
    var set_module_status = path_root + "configuration/change_credit_card_status_for_payout";
    $.post(set_module_status, { id: id, module_status: module_status }, function(data) {
        location.reload();
    });
}
$('.paypal_status').on('click', function() {
    var base_url = $('#base_url').val();
    $(this).closest('.panel').prev('.alert').remove();
    var id = $(this).data('id');
    var status = $(this).data('status');
    var element = $(this);
    $.ajax({
        'url': base_url + "admin/configuration/change_credit_card_status_for_payout",
        'type': "POST",
        'data': { id: id, module_status: status },
        'dataType': 'json',
        'beforeSend': function() {
            var img_url = $('#base_url').val() + 'public_html/images/loading.gif';
            var img = '<img style="margin: 5px 0 0 10px;" src="' + img_url + '"/>';
            $(element).closest('.switch').after(img);
        },
        'success': function(data) {
            if (data.response) {
                var box = $('#success-box').clone();
                $(box).css('display', 'block');
                $(box).attr('id', '');
                $(element).closest('.panel').before(box);
                location.reload();
                // $('html,body').animate({scrollTop: 0}, 1000);
            } else {
                $(element).prop('checked', !status);
                var box = $('#error-box').clone();
                $(box).css('display', 'block');
                $(box).attr('id', '');
                $(element).closest('.panel').before(box);
                // $('html,body').animate({scrollTop: 0}, 1000);
            }
        },
        'error': function(error) {
            $(element).prop('checked', !status);
            var box = $('#error-box').clone();
            $(box).css('display', 'block');
            $(box).attr('id', '');
            $(element).closest('.panel').before(box);
            location.reload();
            // $('html,body').animate({scrollTop: 0}, 1000);
        },
        'complete': function() {
            setTimeout(function() {
                $(element).closest('.switch').next('img').remove();
            }, 500);
        }
    });
});

//kyc
var ValidateKycConfiguration = function() {
    if ($('#current_url').val() != 'configuration/kyc_configuration') {
        return;
    }
    var runValidatorKycConfig = function() {
        var msg1 = $("#msg1").html();
        var msg2 = $("#msg2").html();
        var kyc = $("#lang_kyc").html();

        var searchform = $('#kyc_config');
        var errorHandler1 = $('.errorHandler', searchform);
        $.validator.addMethod("alpha_numeric", function(value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z0-9 ]+$/);
        });
        $('#kyc_config').validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            ignore: ':hidden',
            rules: {
                new_catg: {
                    required: true,
                    alpha_numeric: true
                }
            },
            messages: {
                new_catg: {
                    required: msg2,
                    alpha_numeric: msg1.replace('%s', kyc),
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

    return {
        //main function to initiate template pages
        init: function() {
            runValidatorKycConfig();
        }
    };
}();

function additionalBonusConfig() {
    var base_url = $('#base_url').val();
    $('.additional_bonus').on('click', function() {
        $(this).closest('table').prev('.alert').remove();
        var bonus_name = $(this).data('name');
        var status = $(this).is(':checked');
        var element = $(this);
        $.ajax({
            'url': base_url + "admin/configuration/update_additional_bonus",
            'type': "POST",
            'data': { bonus_name: bonus_name, status: status },
            'dataType': 'json',
            'beforeSend': function() {

            },
            'success': function(data) {
                if (data.response) {
                    var box = $('#success-box').clone();
                    $(box).css('display', 'block');
                    $(element).closest('table').before(box);
                    setTimeout(function() {
                        location.reload();
                    }, 500)
                } else {
                    $(element).prop('checked', !status);
                    var box = $('#error-box').clone();
                    $(box).css('display', 'block');
                    $(element).closest('table').before(box);
                }
            },
            'error': function(error) {
                $(element).prop('checked', !status);
                var box = $('#error-box').clone();
                $(box).css('display', 'block');
                $(element).closest('table').before(box);
            },
            'complete': function(jqXHR, textStatus) {
                if (textStatus == 'parsererror') {
                    location.reload();
                }
            }
        });
    });
}