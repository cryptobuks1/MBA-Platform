var input_group_hide = $('#input_group_hide').val();
var input_group_showed = $.isEmptyObject(input_group_hide.trim());
$(function() {
    getLevelCommissions($("#commission_upto_level").val());
    $("#xup_level").inputFilter(function(value) {
        return /^\d*$/.test(value);
    });
    $('.tab').find('.content').find('.form-group:last').find('button[type="submit"]').parent().next('hr.new_line').remove();
    ValidateConfiguration.init();

    /*if ($('#level_commission_criteria').val() == 'genealogy') {
        $("#genealogy_view").show();
        $("#reg_pck_view").hide();
        $("#member_pck_view").hide();
    } else if ($('#level_commission_criteria').val() == 'reg_pck') {
        $("#genealogy_view").hide();
        $("#reg_pck_view").show();
        $("#member_pck_view").hide();
    } else {
        $("#genealogy_view").hide();
        $("#reg_pck_view").hide();
        $("#member_pck_view").show();
    }
    $('#level_commission_criteria').trigger("change");*/
    $("#level_commission_type").change();
});
var ValidateConfiguration = function() {
    $("#level_commission_type").change(function() {
        if ($(this).val() === 'percentage') {
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
        var msg9 = $("#validate_msg18").html();
        var msg10 = $("#validate_msg12").html();
        var msg11 = $("#validate_msg19").html();
        var msg6 = $("#validate_msg13").html();
        var msg7 = $("#validate_msg16").html();
        var msg8 = $("#validate_msg17").html();
        var msg17 = $("#validate_msg25").html();
        var msg19 = $("#validate_msg31").html();

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
                xup_level: {
                    required: true,
                    digits: true,
                    min: 1,
                    max: 3
                }
            },
            messages: {
                xup_level: {
                    required: msg11,
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
                    maxlength: msg19,
                }
            });
            if ($("#level_commission_type").val() === 'percentage') {
                $('.level_percentage').each(function() {
                    $(this).rules('add', {
                        max: 100,
                        messages: {
                            max: msg17
                        }
                    });
                });
            }
            $("#level_commission_type").change(function() {
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
    };

    var runValidateConfig = function() {
        var msg9 = $("#upto_level").html();
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



function setHiddenValue(tab) {
    $("#active_tab").val(tab);
}

function change_level_commission_type(val) {
    if (val == 'percentage') {
        $(".span_level_commission").html("(%)");
    } else {
        $(".span_level_commission").html('');
    }
}

function set_cleanup_flag(current_value, new_value) {
    var cleanup_flag = document.getElementById('cleanup_flag').value;
    if (current_value != new_value && cleanup_flag != 1) {
        $("#cleanup_flag").val("1");
    }
}

function getLevelCommissions(level) {
    var view_url = $('#view_url').val();
    $.ajax({
        async: false,
        type: "POST",
        url: view_url,
        data: {
            level: level
        },
        beforeSend: function() {

        },
        success: function(data) {
            if (data == 'invalid')
                location.reload();
            $('#level_div').html(data);
        }
    });
}
/*$('#commission_upto_level').on('change', function() {
    getLevelCommissions($(this).val());
    $('#level_commission_criteria').trigger("change");
    ValidateConfiguration.init();
});*/